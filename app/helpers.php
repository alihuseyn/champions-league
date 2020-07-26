<?php

/**
 * Return given number in ordinal format
 *
 * @param integer $number
 *
 * @return string
 */
function ordinal($number)
{
    $locale = 'en_US';
    $format = new NumberFormatter($locale, NumberFormatter::ORDINAL);
    return $format->format($number);
}
