<?php

namespace subzeta\HistDataApi\Tests\Util;

use subzeta\HistDataApi\Util\Instrument;

class InstrumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function givenAnInvalidInstrumentIsValidReturnFalse()
    {
        $this->assertFalse(Instrument::isValid('invalid_instrument'));
    }

    /**
     * @test
     */
    public function givenAValidInstrumentIsValidItReturnTrue()
    {
        $this->assertTrue(Instrument::isValid(Instrument::CHF_JPY));
    }

    /**
     * @test
     */
    public function allReturnsAnArrayOfInstruments()
    {
        $this->assertNotEmpty(Instrument::all());
    }

    /**
     * @test
     */
    public function mapReturnsAnLoweredStringWithoutSlashes()
    {
        $this->assertSame('eurusd', Instrument::map(Instrument::EUR_USD));
    }
}
