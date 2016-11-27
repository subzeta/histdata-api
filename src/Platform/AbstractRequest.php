<?php

namespace subzeta\HistDataApi\Platform;

use subzeta\HistDataApi\Client;
use subzeta\HistDataApi\Exception\HttpRuntimeException;
use subzeta\HistDataApi\Util\Instrument;

abstract class AbstractRequest
{
    const HIST_DATA_TIMEZONE = 'EST';

    private $client;

    protected $year;

    protected $month;

    protected $instrument;

    abstract protected function getEndpoint() : string;

    abstract public function get() : array;

    public function __construct(Client $client, string $year, string $month, string $instrument)
    {
        $this->client = $client;
        $this->year = $year;
        $this->month = str_pad($month, 2, '0', STR_PAD_LEFT);
        $this->instrument = Instrument::map($instrument);
    }

    protected function download() : string
    {
        try {
            return $this->client->download($this->getEndpoint());
        } catch (\Throwable $e) {
            throw new HttpRuntimeException($e->getMessage());
        }
    }
}
