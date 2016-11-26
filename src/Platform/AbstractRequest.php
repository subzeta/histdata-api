<?php

namespace subzeta\HistDataApi\Platform;

use subzeta\HistDataApi\Client;

abstract class AbstractRequest
{
    const HIST_DATA_TIMEZONE = 'EST';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param \subzeta\HistDataApi\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract public function getEndpoint($instrument, $year, $month);

    /**
     * @return Client
     */
    protected function getClient()
    {
        return $this->client;
    }

    public function download($year, $month, $instrument)
    {
        return $this->getClient()->download($this->getEndpoint($instrument, $year, $month));
    }
}
