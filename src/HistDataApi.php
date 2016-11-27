<?php

namespace subzeta\HistDataApi;

use Carbon\Carbon;
use subzeta\HistDataApi\Exception\InvalidArgumentException;
use subzeta\HistDataApi\Platform\AbstractRequest;
use subzeta\HistDataApi\Platform\ASCIIOneMinuteBarRequest;
use subzeta\HistDataApi\Util\Instrument;

class HistDataApi
{
    public function fetchAsciiOneMinuteBar(string $year, string $month, string $instrument) : AbstractRequest
    {
        return $this->fetch(ASCIIOneMinuteBarRequest::class, $year, $month, $instrument);
    }

    private function fetch(string $class, string $year, string $month, string $instrument) : AbstractRequest
    {
        $this->validate($year, $month, $instrument);

        return new $class(new Client(), $year, $month, $instrument);
    }

    private function validate($year, $month, $instrument)
    {
        try {
            $yearAndMonth = new Carbon($year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01');

            if (!$yearAndMonth || $yearAndMonth < new Carbon('2002-01-01') || $yearAndMonth > Carbon::now()) {
                throw new \Exception();
            }
        } catch (\Throwable $e) {
            throw new InvalidArgumentException(
                'Year and month must be greater than first of January of 2002 and lower than today'
            );
        }

        if (!Instrument::isValid($instrument)) {
            throw new InvalidArgumentException('Unexpected or null instrument.');
        }
    }
}
