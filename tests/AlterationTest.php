<?php
/**
 * Contains the AlterationTest class.
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

class AlterationTest extends TestCase
{
    /**
     * @test
     * @dataProvider absProvider
     */
    public function absolute_value_can_be_obtained($input, $expected)
    {
        $dec = new Decimal($input);

        $this->assertSame($expected, (string)$dec->abs());
    }

    /**
     * @test
     * @dataProvider negationProvider
     */
    public function negated_value_can_be_obtained($input, $expected)
    {
        $dec = new Decimal($input);

        $negative = $dec->negative;
        $this->assertSame($expected, (string)$dec->negation());

        $dec->negate();
        $this->assertSame(!$negative, $dec->negative);
        $this->assertSame($expected, (string)$dec);
    }

    /**
     * @test
     * @dataProvider roundProvider
     */
    public function can_be_rounded($input, $precision, $expected)
    {
        $d = new Decimal($input);

        $this->assertSame($expected, (string)$d->round($precision));
    }

    /**
     * @test
     * @dataProvider toFloatProvider
     */
    public function can_be_converted_to_float($input, $expected)
    {
        $d = new Decimal($input);

        $result = $d->toFloat();

        $this->assertInternalType('float', $result);

        $this->assertEquals($expected, $result);
    }

    public function absProvider()
    {
        return [
            [0, '0'],
            [1, '1'],
            [-1, '1'],
            ['12.375', '12.375'],
            ['-12.375', '12.375'],
            [-0.7, '0.7'],
            [0.7, '0.7'],
            ['6.22e23', '622000000000000000000000'],
            ['-6.22e23', '622000000000000000000000'],
            ['1e-10', '0.0000000001'],
            ['-1e-10', '0.0000000001'],
        ];
    }

    public function negationProvider()
    {
        return [
            [0, '0'],
            [1, '-1'],
            [-1, '1'],
            ['12.375', '-12.375'],
            ['-12.375', '12.375'],
            [-0.7, '0.7'],
            [0.7, '-0.7'],
            ['6.22e23', '-622000000000000000000000'],
            ['-6.22e23', '622000000000000000000000'],
            ['1e-10', '-0.0000000001'],
            ['-1e-10', '0.0000000001'],
        ];
    }

    public function roundProvider()
    {
        return [
            ['12.375', -1, '12'],
            ['12.375', 0, '12'],
            ['12.375', 1, '12.4'],
            ['12.375', 2, '12.38'],
            ['12.375', 3, '12.375'],
            ['12.375', 4, '12.375'],
        ];
    }

    public function toFloatProvider()
    {
        return [
            [0, 0.0],
            [1, 1.0],
            [-1, -1.0],
            ['12.375', 12.375],
            [-0.7, -0.7],
            [0.7, 0.7],
            ['6.22e23', 622000000000000000000000.0],
            ['-6.22e23', -622000000000000000000000.0],
            ['1e-10', 0.0000000001],
            ['-1e-10', -0.0000000001],
            ['1e100', 10.0 ** 100],
        ];
    }
}
