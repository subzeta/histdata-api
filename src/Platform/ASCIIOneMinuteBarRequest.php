<?php

namespace subzeta\HistDataApi\Platform;

class ASCIIOneMinuteBarRequest extends AbstractRequest
{
    const QUOTES_ENDPOINT = 'ascii/1-minute-bar-quotes/%s/%s/%s/HISTDATA_COM_ASCII_%s_M1_%s%s.zip';

    public function getEndpoint($instrument, $year, $month)
    {
        return sprintf(self::QUOTES_ENDPOINT, $instrument, $year, $month, $instrument, $year, (int)$month);
    }

    public function fetch($year, $month, $instrument)
    {
        $rows = [];

        foreach (explode("\n", $this->download($year, $month, $instrument)) as $row) {
            if (strlen($row) === 0) {
                continue;
            }
            list($datetime, $openBid, $highBid, $lowBid, $closeBid, $volume) = str_getcsv($row, ';');

            try{
                $rows[] = [
                    'datetime' => $datetime,
                    'open_bid' => $openBid,
                    'high_bid' => $highBid,
                    'low_bid' => $lowBid,
                    'close_bid' => $closeBid,
                    'volume' => $volume,
                ];
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return $rows;
    }
}