<?php

namespace subzeta\HistDataApi;

use Carbon\Carbon;
use subzeta\HistDataApi\Platform\ASCIIOneMinuteBarRequest;
use subzeta\HistDataApi\Util\Instrument;
use subzeta\HistDataApi\Util\Platform;

class HistDataApi
{
    const ASCII_ONE_MINUTE_BAR = 1;

    public function import($platform, $year, $month, $instrument, $from, $inDateTime = 'utc')
    {
        $this->validate($platform, $year, $month, $instrument, $from, $inDateTime);

        $instrument = (new Instrument())->map($instrument);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        return $this->factory($platform)->fetch($year, $month, $instrument, $from, $inDateTime);
    }

    private function factory($platform)
    {
        switch ($platform) {
            case self::ASCII_ONE_MINUTE_BAR:
                return new ASCIIOneMinuteBarRequest(new Client());
        }

        return null;
    }

    private function validate($platform, $year, $month, $instrument, $from, $inDateTime = 'utc')
    {
        if (!in_array($platform, (new Platform())->all())) {
            throw new \InvalidArgumentException('Unexpected or null platform.');
        }

        $yearAndMonth = new Carbon($year.'-'.((int)$month < 10 ? '0'.$month : $month).'-01');
        if ($yearAndMonth < new Carbon('2002-01-01') || $yearAndMonth > Carbon::now()) {
            throw new \InvalidArgumentException(
                'Year and month must be greater than first of January of 2002 and lower than today'
            );
        }

        if (!in_array($instrument, (new Instrument())->all())) {
            throw new \InvalidArgumentException('Unexpected or null instrument.');
        }
    }
}