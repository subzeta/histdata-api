<?php

namespace subzeta\HistDataApi;

class Client
{
    const DOWNLOAD_ENDPOINT = 'http://www.histdata.com/get.php';
    const BASE_ENDPOINT = 'http://www.histdata.com/download-free-forex-historical-data/?/';

    public function download(string $endpoint) : string
    {
        return $this->unzip($this->get($endpoint));
    }

    private function get(string $endpoint) : string
    {
        $parts = explode('/', $endpoint);
        $file = array_pop($parts);

        $init_url = self::BASE_ENDPOINT.implode('/', $parts);
        $filename = sys_get_temp_dir().'/'.uniqid().'.zip';

        $ch = curl_init($init_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);

        $output = curl_exec($ch);

        preg_match('/^Set-Cookie:\s*([^;]*)/mi', $output, $m);
        parse_str($m[1], $cookies);

        $post_array = $this->getPostArray($output);
        $post_data = http_build_query($post_array);

        $header = [
            "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5",
            "Cache-Control: max-age=0",
            "Connection: keep-alive",
            "Keep-Alive: 300",
            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Accept-Language: en-us,en;q=0.5",
            "Pragma: ",
            "Content-Type: application/x-www-form-urlencoded",
        ];

        $ch = curl_init(self::DOWNLOAD_ENDPOINT);
        curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookies));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($ch, CURLOPT_REFERER, self::BASE_ENDPOINT.$init_url.'/'.$file);

        $output = curl_exec($ch);
        $fp = fopen($filename,'wb');
        if (!$fp) {
            throw new \Exception('Cannot open file for writing!' . $filename);
        }
        fwrite($fp, $output);
        fclose($fp);

        return $filename;
    }

    private function getPostArray($doc) : array
    {
        $post_items = [];
        $dom_doc = new \DOMDocument;

        if (!@$dom_doc->loadhtml($doc)) {
            throw new \Exception('Could not load html!');
        } else {
            $xpath = new \DOMXpath($dom_doc);

            foreach($xpath->query('//form[@name="file_down"]//input') as $input) {
                //get name and value of input
                $input_name = $input->getAttribute('name');
                $input_value = $input->getAttribute('value');
                $post_items[$input_name] = $input_value;
            }
        }

        return $post_items;
    }

    private function unzip(string $filename) : string
    {
        $zip = new \ZipArchive();
        if ($zip->open($filename)) {
            return $zip->getFromIndex(0);
        }

        throw new \Exception('Couldn\'t open the zip file.');
    }
}