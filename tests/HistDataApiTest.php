<?php

namespace subzeta\HistDataApi\Tests;

use subzeta\HistDataApi\HistDataApi;
use subzeta\HistDataApi\Platform\ASCIIOneMinuteBarRequest;
use subzeta\HistDataApi\Util\Instrument;

class HistDataApiTest extends \PHPUnit_Framework_TestCase
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
     */
    public function givenACorrectCallItWorks()
    {
        $this->assertInstanceOf(
            ASCIIOneMinuteBarRequest::class,
            $this->api->fetchAsciiOneMinuteBar(date('Y'), date('m'), Instrument::AUD_JPY)
        );
    }

    /**
     * @test
     *
     * @param string $year
     * @param string $month
     * @param string $instrument
     *
     * @dataProvider invalidParameters
     */
    public function givenAGroupOfInvalidParametersItShouldThrowAnInvalidArgumentException($year, $month, $instrument)
    {
        $this->expectException('subzeta\HistDataApi\Exception\InvalidArgumentException');

        $this->api->fetchAsciiOneMinuteBar($year, $month, $instrument);
    }

    public function invalidParameters() : array
    {
        return [
            [
                date('Y') + 1,
                date('m'),
                Instrument::AUD_JPY
            ],
            [
                date('Y') - 3,
                date('m') + 12,
                Instrument::AUD_JPY
            ],
            [
                date('Y'),
                date('m') + 1,
                Instrument::AUD_JPY
            ],
            [
                date('Y'),
                date('m'),
                'invalid_instrument'
            ]
        ];
    }
}
