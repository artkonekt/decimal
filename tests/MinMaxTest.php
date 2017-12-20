<?php
/**
 * Contains the MinMaxTest class.
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

class MinMaxTest extends TestCase
{
    /**
     * @test
     * @dataProvider minProvider
     */
    public function min_value_can_be_returned_from_several_decimals($args, $expected)
    {
        $this->assertSame($expected, (string)Decimal::min(...$args));
    }


    /**
     * @test
     * @dataProvider maxProvider
     */
    public function max_value_can_be_returned_from_several_decimals($args, $expected)
    {
        $this->assertSame($expected, (string)Decimal::max(...$args));
    }

    public function minProvider()
    {
        return [
            [[], ''],
            [[1], '1'],
            [[0, 1, 2], '0'],
            [[2, 1, 0], '0'],
            [[1, 0, 2], '0'],
            [[-5.0, -7.3, -25], '-25'],
            [[-100, '-1e5', -25], '-100000'],
        ];
    }

    public function maxProvider()
    {
        return [
            [[], ''],
            [[1], '1'],
            [[0, 1, 2], '2'],
            [[2, 1, 0], '2'],
            [[1, 0, 2], '2'],
            [[-5.0, -7.3, -25], '-5'],
            [[100, '1e5', 25], '100000'],
        ];
    }
}
