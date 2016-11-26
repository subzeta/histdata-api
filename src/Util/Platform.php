<?php

namespace subzeta\HistDataApi\Util;

class Platform
{
    const ASCII_ONE_MINUTE_BAR = 'AsciiOneMinuteBar';

    /**
     * @return array
     */
    public function all()
    {
        return (new \ReflectionClass($this))->getConstants();
    }
}