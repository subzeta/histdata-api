<?php

namespace subzeta\HistDataApi\Tests\Platform;

use subzeta\HistDataApi\Platform\ASCIIOneMinuteBarRequest;
use subzeta\HistDataApi\Util\Instrument;

class ASCIIOneMinuteBarRequestTest extends \PHPUnit_Framework_TestCase
{
    use TestableClientTrait;

    /**
     * @test
     */
    public function givenNoResultsItReturnsAnEmptyArray()
    {
        $this->assertEmpty(
            (new ASCIIOneMinuteBarRequest(
                $this->getClientMock(''),
                date('Y'),
                date('m'),
                Instrument::EUR_USD)
            )->get()
        );
    }

    /**
     * @test
     */
    public function givenResultsItReturnsAnArrayOfRows()
    {
        $response = (new ASCIIOneMinuteBarRequest(
            $this->getClientMock(file_get_contents(__DIR__.'/../Response/ASCIIOneMinuteBarExpectedResponse.txt')),
            date('Y'),
            date('m'),
            Instrument::EUR_USD)
        )->get();

        $line = array_pop($response);

        $this->assertNotEmpty($response);

        $this->assertSame(6, count($line));
    }

    /**
     * @test
     */
    public function givenInvalidResultsItThrowsAnHttpResponseException()
    {
        $this->expectException('subzeta\HistDataApi\Exception\HttpResponseException');

        (new ASCIIOneMinuteBarRequest(
            $this->getClientMock(file_get_contents(__DIR__.'/../Response/ASCIIOneMinuteBarUnexpectedResponse.txt')),
            date('Y'),
            date('m'),
            Instrument::EUR_USD)
        )->get();
    }

    /**
     * @test
     */
    public function givenAnHttpErrorItThrowsAnHttpRuntimeException()
    {
        $this->expectException('subzeta\HistDataApi\Exception\HttpRuntimeException');

        (new ASCIIOneMinuteBarRequest(
            $this->getClientMock('', '\Exception'),
            date('Y'),
            date('m'),
            Instrument::EUR_USD)
        )->get();
    }
}
