<?php
/**
 * Contains the OtherOperationsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal\Tests;

use Konekt\Decimal\Decimal;
use PHPUnit\Framework\TestCase;

class OtherOperationsTest extends TestCase
{
    /**
     * @test
     * @dataProvider inverseProvider
     */
    public function an_inverse_number_can_be_obtained($input, $scale, $expected)
    {
        $dec = new Decimal($input);

        $this->assertSame($expected, (string)$dec->inverse($scale));
    }

    /**
     * @test
     * @dataProvider compressProvider
     */
    public function numbers_can_be_compressed($input, $expected)
    {
        $d = new Decimal;

        list($d->digits, $d->exponent, $d->negative) = $input;
        $d                                           = $d->compress();

        $this->assertSame($expected, [$d->digits, $d->exponent, $d->negative]);
    }

    /**
     * @test
     * @dataProvider quantizeProvider
     */
    public function numbers_can_be_quantized($input, $exponent, $expected)
    {
        $d = new Decimal($input);
        $this->assertSame($expected, (string)$d->quantize($exponent));
    }

    /**
     * @test
     * @dataProvider quantizeMethodProvider
     */
    public function quantize_accepts_multiple_methods($input, $exponent, $method, $expected)
    {
        $d = new Decimal($input);

        $q = $d->quantize($exponent, $method);

        $this->assertSame($expected, (string)$q);
    }

    public function quantizeMethodProvider()
    {
        return [
            ['12.375', -2, PHP_ROUND_HALF_UP, '12.38'],
            ['12.375', -2, PHP_ROUND_HALF_DOWN, '12.37'],
            ['12.375', -2, PHP_ROUND_HALF_EVEN, '12.38'],
            ['12.375', -2, PHP_ROUND_HALF_ODD, '12.37'],
            ['-0.05', -1, PHP_ROUND_HALF_UP, '-0.1'],
            ['-0.05', -1, PHP_ROUND_HALF_DOWN, '0'],
            ['-0.05', -1, PHP_ROUND_HALF_EVEN, '0'],
            ['-0.05', -1, PHP_ROUND_HALF_ODD, '-0.1'],
        ];
    }

    public function inverseProvider()
    {
        return [
            [1, null, '1'],
            [-1, null, '-1'],
            [2, null, '0.5'],
            [1000, null, '0.001'],
            ['-10', null, '-0.1'],
            ['10', null, '0.1'],
            ['10', 0, '0'],
            ['0.1', null, '10'],
            ['-0.001', null, '-1000'],
            [3, 3, '0.333'],
            [3, 0, '0'],
            [6, 4, '0.1666'],
            [6, 3, '0.166'],
            [6, 2, '0.16'],
            [6, 1, '0.1'],
            ['6.22e23', 30, '0.000000000000000000000001607717'],
        ];
    }

    public function compressProvider()
    {
        return [
            [['0', 0, false], ['0', 0, false]],
            [['0', 1, false], ['0', 0, false]],
            [['0', 0, true], ['0', 0, false]],
            [['00000000', 0, false], ['0', 0, false]],
            [['75', 2, false], ['75', 2, false]],
            [['750', 1, false], ['75', 2, false]],
            [['7500', 0, false], ['75', 2, false]],
            [['75000', -1, false], ['75', 2, false]],
            [['001', -8, true], ['1', -10, true]],
            [['01', -9, true], ['1', -10, true]],
            [['1', -10, true], ['1', -10, true]],
            [['10', -11, true], ['1', -10, true]],
            [['100', -12, true], ['1', -10, true]],
        ];
    }

    public function quantizeProvider()
    {
        return [
            ['12.375', 3, '0'],
            ['12.375', 2, '0'],
            ['12.375', 1, '10'],
            ['12.375', 0, '12'],
            ['12.375', -1, '12.4'],
            ['12.375', -2, '12.38'],
            ['12.375', -3, '12.375'],
            ['12.375', -4, '12.375'],
            ['1500', 3, '1500'],
        ];
    }
}
