<?php
/**
 * Contains the ScaleTest class.
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

class ScaleTest extends TestCase
{
    /**
     * @test
     * @dataProvider scaleProvider
     */
    public function it_properly_returns_the_scale_of_a_number($input, $expected)
    {
        $d = new Decimal($input);
        $this->assertSame($expected, $d->getScale());
    }

    /**
     * @test
     * @dataProvider resultScaleProvider
     */
    public function result_scale_can_be_calculated_from_two_decimals($a, $b, $scale, $expected)
    {
        $this->assertSame(
            $expected,
            Decimal::resultScale(
                new Decimal($a),
                new Decimal($b),
                $scale
            )
        );
    }

    public function scaleProvider()
    {
        return [
            [0, 0],
            [1, 0],
            [-1, 0],
            ['12.375', 3],
            ['-0.7', 1],
            ['6.22e23', 0],
            ['1e-10', 10],
        ];
    }

    public function resultScaleProvider()
    {
        return [
            ['0', '0', null, 0],
            ['1', '10', null, 0],
            ['1000', '10', null, 0],
            ['-10', '10', null, 0],
            ['10', '-10', null, 0],
            ['0.1', '1', null, 1],
            ['0.1', '0.01', null, 2],
            ['-0.001', '0.01', null, 3],
            ['0', '0', 3, 3],
            ['1000', '0.001', 0, 0],
        ];
    }

}
