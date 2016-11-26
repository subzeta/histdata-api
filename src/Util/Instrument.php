<?php

namespace subzeta\HistDataApi\Util;

class Instrument
{
    const AUD_CAD = 'AUD/CAD';
    const AUD_CHF = 'AUD/CHF';
    const AUD_JPY = 'AUD/JPY';
    const AUD_NZD = 'AUD/NZD';
    const AUD_USD = 'AUD/USD';
    const AUX_AUD = 'AUX/AUD';
    const BCO_USD = 'BCO/USD';
    const CHF_JPY = 'CHF/JPY';
    const CAD_CHF = 'CAD/CHF';
    const CAD_JPY = 'CAD/JPY';
    const ETX_EUR = 'ETX/EUR';
    const EUR_AUD = 'EUR/AUD';
    const EUR_CAD = 'EUR/CAD';
    const EUR_CHF = 'EUR/CHF';
    const EUR_CZK = 'EUR/CZK';
    const EUR_DKK = 'EUR/DKK';
    const EUR_GBP = 'EUR/GBP';
    const EUR_HUF = 'EUR/HUF';
    const EUR_JPY = 'EUR/JPY';
    const EUR_NOK = 'EUR/NOK';
    const EUR_NZD = 'EUR/NZD';
    const EUR_PLN = 'EUR/PLN';
    const EUR_SEK = 'EUR/SEK';
    const EUR_USD = 'EUR/USD';
    const EUR_TRY = 'EUR/TRY';
    const FRX_EUR = 'FRX/EUR';
    const GBP_CHF = 'GBP/CHF';
    const GBP_AUD = 'GBP/AUD';
    const GBP_CAD = 'GBP/CAD';
    const GBP_JPY = 'GBP/JPY';
    const GBP_NZD = 'GBP/NZD';
    const GBP_USD = 'GBP/USD';
    const GRX_EUR = 'GRX/EUR';
    const HKX_HKD = 'HKX/HKD';
    const JPX_JPY = 'JPX/JPY';
    const NZD_CAD = 'NZD/CAD';
    const NZD_CHF = 'NZD/CHF';
    const NZD_JPY = 'NZD/JPY';
    const NZD_USD = 'NZD/USD';
    const NSX_USD = 'NSX/USD';
    const SGD_JPY = 'SGD/JPY';
    const SPX_USD = 'SPX/USD';
    const UDX_USD = 'UDX/USD';
    const UKX_GBP = 'UKX/GBP';
    const USD_CAD = 'USD/CAD';
    const USD_CHF = 'USD/CHF';
    const USD_CZK = 'USD/CZK';
    const USD_DKK = 'USD/DKK';
    const USD_JPY = 'USD/JPY';
    const USD_HKD = 'USD/HKD';
    const USD_HUF = 'USD/HUF';
    const USD_MXN = 'USD/MXN';
    const USD_NOK = 'USD/NOK';
    const USD_PLN = 'USD/PLN';
    const USD_SEK = 'USD/SEK';
    const USD_SGD = 'USD/SGD';
    const USD_TRY = 'USD/TRY';
    const USD_ZAR = 'USD/ZAR';
    const XAG_USD = 'XAG/USD';
    const XAU_AUD = 'XAU/AUD';
    const XAU_CHF = 'XAU/CHF';
    const XAU_EUR = 'XAU/EUR';
    const XAU_GBP = 'XAU/GBP';
    const XAU_USD = 'XAU/USD';
    const WTI_USD = 'WTI/USD';
    const ZAR_JPY = 'ZAR/JPY';

    /**
     * @param string $instrument
     *
     * @return string
     */
    public function map($instrument)
    {
        return strtolower(str_replace('/', '', $instrument));
    }

    /**
     * @return array
     */
    public function all()
    {
        return (new \ReflectionClass($this))->getConstants();
    }
}