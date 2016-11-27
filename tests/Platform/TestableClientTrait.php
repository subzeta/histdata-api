<?php

namespace subzeta\HistDataApi\Tests\Platform;

use subzeta\HistDataApi\Client;

trait TestableClientTrait
{
    public function getClientMock(string $response, string $exception = '') : Client
    {
        $client = \Mockery::mock(Client::class)->makePartial();
        if (empty($exception)) {
            $client->shouldReceive('download')->andReturn($response);
        } else {
            $client->shouldReceive('download')->andThrow($exception);
        }

        return $client;
    }
}
