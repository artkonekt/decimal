<?php
/**
 * Contains the Formatter class.
 *
 * @copyright   Copyright (c) 2014 direvus
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal;

class Formatter
{
    public $places;
    public $grouping;
    public $radix_mark;

    public function __construct(
        $places = null,
        $grouping = '',
        $radix_mark = RADIX_MARK
    ) {
        $this->places     = $places;
        $this->grouping   = $grouping;
        $this->radix_mark = $radix_mark;
    }

    public function format($decimal)
    {
        if ($decimal === '' || $decimal === null) {
            $decimal = 0;
        }
        if ($decimal instanceof Decimal) {
            $decimal = $decimal->compress();
        } else {
            $decimal = new Decimal($decimal);
        }
        if ($this->places !== null && $this->places != $decimal->getScale()) {
            $decimal = $decimal->round($this->places);
        }
        if ($decimal->exponent >= 0) {
            $fill     = Decimal::zeroes($decimal->exponent);
            $intpart  = $decimal->digits . $fill;
            $fracpart = '';
        } else {
            $intpart  = substr($decimal->digits, 0, $decimal->exponent);
            $fracpart = substr($decimal->digits, $decimal->exponent);
            $len      = strlen($fracpart);
            $scale    = $decimal->getScale();
            if ($len < $scale) {
                $fracpart = Decimal::zeroes($scale - $len) . $fracpart;
            }
        }
        if ($intpart == '') {
            $intpart = ZERO;
        }
        $grouplen = strlen($this->grouping);
        if ($grouplen > 0) {
            for ($i = 3; $i < strlen($intpart); $i += 3 + $grouplen) {
                $intpart = substr_replace($intpart, $this->grouping, -$i, 0);
            }
        }
        $result = '';
        if ($decimal->negative) {
            $result = '-';
        }
        $result .= $intpart;
        if (strlen($fracpart) > 0) {
            $result .= $this->radix_mark . $fracpart;
        }

        return $result;
    }
}
