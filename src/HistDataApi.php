<?php

namespace subzeta\HistDataApi;

use Carbon\Carbon;
use subzeta\HistDataApi\Platform\ASCIIOneMinuteBarRequest;
use subzeta\HistDataApi\Util\Instrument;
use subzeta\HistDataApi\Util\Platform;

class HistDataApi
{
    public function import(string $platform, string $year, string $month, string $instrument) : array
    {
        $this->validate($platform, $year, $month, $instrument);

        $instrument = (new Instrument())->map($instrument);
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        return $this->factory($platform)->fetch($year, $month, $instrument);
    }

    private function factory($platform)
    {
        switch ($platform) {
            case Platform::ASCII_ONE_MINUTE_BAR:
                return new ASCIIOneMinuteBarRequest(new Client());
        }

        return null;
    }

    private function validate($platform, $year, $month, $instrument)
    {
        if (!in_array($platform, (new Platform())->all())) {
            throw new \InvalidArgumentException('Unexpected or null platform.');
        }

        try {
            $yearAndMonth = new Carbon($year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01');

            if (!$yearAndMonth || $yearAndMonth < new Carbon('2002-01-01') || $yearAndMonth > Carbon::now()) {
                throw new \Exception();
            }
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException(
                'Year and month must be greater than first of January of 2002 and lower than today'
            );
        }

        if (!in_array($instrument, (new Instrument())->all())) {
            throw new \InvalidArgumentException('Unexpected or null instrument.');
        }
    }
}