<?php

namespace subzeta\HistDataApi\Platform;

use Carbon\Carbon;

class ASCIIOneMinuteBarRequest extends AbstractRequest
{
    const QUOTES_ENDPOINT = 'ascii/1-minute-bar-quotes/%s/%s/%s/HISTDATA_COM_ASCII_%s_M1_%s%s.zip';

    public function getEndpoint($instrument, $year, $month)
    {
        return sprintf(self::QUOTES_ENDPOINT, $instrument, $year, $month, $instrument, $year, (int)$month);
    }

    public function fetch($year, $month, $instrument, $from, $inDateTime)
    {
        $saveFromNow = false;

        $rows = [];
        foreach (file($this->download($year, $month, $instrument)) as $row) {
            if (!$saveFromNow) {
                $saveFromNow = is_null($from) || $from < substr($row, 0, 15);
                if (!$saveFromNow) {
                    continue;
                }
            }

            list($datetime, $openBid, $highBid, $lowBid, $closeBid, $volume) = str_getcsv($row, ';');

            try{
                $rows[] = [
                    'datetime' => (new Carbon($datetime, self::HIST_DATA_TIMEZONE))
                        ->setTimezone($inDateTime)
                        ->format('Y-m-d H:i:s'),
                    'instrument_id' => $instrument,
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