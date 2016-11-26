<?php

namespace subzeta\Glosbe\Test;

use subzeta\HistDataApi\HistDataApi;
use subzeta\HistDataApi\Util\Instrument;
use subzeta\HistDataApi\Util\Platform;

class HistDatApi extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HistDataApi
     */
    private $api;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->api = new HistDataApi();
    }

    /**
     * @test
     *
     * @dataProvider invalidParameters
     *
     * @expectedException \InvalidArgumentException
     */
    public function givenAGroupOfInvalidParametersItShouldThrowAnInvalidArgumentException(
        string $platform,
        int $year,
        int $month,
        string $instrument,
        \DateTime $from = null,
        string $timezone = null
    ) {
        $this->api->import($platform, $year, $month, $instrument, $from, $timezone);
    }

    /**
     * @test
     */
    public function givenACorrectCallItWorks()
    {
        $this->api->import(
            Platform::ASCII_ONE_MINUTE_BAR,
            date('Y'),
            date('m'),
            Instrument::AUD_JPY
        );
    }

    public function invalidParameters()
    {
        return [
            [
                'this_is_an_unknown_platform',
                date('Y'),
                date('m'),
                Instrument::AUD_JPY
            ],
            [
                Platform::ASCII_ONE_MINUTE_BAR,
                date('Y') + 1,
                date('m'),
                Instrument::AUD_JPY
            ],
            [
                Platform::ASCII_ONE_MINUTE_BAR,
                date('Y') - 3,
                date('m') + 12,
                Instrument::AUD_JPY
            ],
            [
                Platform::ASCII_ONE_MINUTE_BAR,
                date('Y'),
                date('m') + 1,
                Instrument::AUD_JPY
            ]
        ];
    }
}