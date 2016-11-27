<?php

namespace subzeta\HistDataApi\Platform;

use subzeta\HistDataApi\Exception\HttpRuntimeException;
use subzeta\HistDataApi\Exception\HttpResponseException;

class ASCIIOneMinuteBarRequest extends AbstractRequest
{
    const QUOTES_ENDPOINT = 'ascii/1-minute-bar-quotes/%s/%s/%s/HISTDATA_COM_ASCII_%s_M1_%s%s.zip';

    protected function getEndpoint() : string
    {
        return sprintf(
            self::QUOTES_ENDPOINT,
            $this->instrument,
            $this->year,
            $this->month,
            $this->instrument,
            $this->year,
            (int)$this->month
        );
    }

    public function get() : array
    {
        $rows = [];

        try {
            foreach (explode("\n", $this->download()) as $row) {
                if (strlen($row) === 0) {
                    continue;
                }
                list($datetime, $openBid, $highBid, $lowBid, $closeBid, $volume) = str_getcsv($row, ';');

                $rows[] = [
                    'datetime'  => $datetime,
                    'open_bid'  => $openBid,
                    'high_bid'  => $highBid,
                    'low_bid'   => $lowBid,
                    'close_bid' => $closeBid,
                    'volume'    => $volume,
                ];
            }
        } catch (HttpRuntimeException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw new HttpResponseException($e->getMessage());
        }

        return $rows;
    }
}
