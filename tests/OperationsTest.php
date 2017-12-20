<?php
/**
 * Contains the OperationsTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal\Tests;

use DivisionByZeroError;
use Konekt\Decimal\Decimal;
use PHPUnit\Framework\TestCase;

class OperationsTest extends TestCase
{
    /**
     * @test
     * @dataProvider additionProvider
     */
    public function decimals_can_be_added($a, $b, $scale, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected, (string)$dec->add($b, $scale));
    }

    /**
     * @test
     * @dataProvider subtractionProvider
     */
    public function decimals_can_be_subtracted($a, $b, $scale, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected, (string)$dec->sub($b, $scale));
        $this->assertSame($expected, (string)$dec->subtract($b, $scale));
    }

    /**
     * @test
     * @dataProvider multiplicationProvider
     */
    public function decimals_can_be_multiplied($a, $b, $scale, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected, (string)$dec->mul($b, $scale));
        $this->assertSame($expected, (string)$dec->multiply($b, $scale));
    }

    /**
     * @test
     * @dataProvider divisionProvider
     */
    public function decimals_can_be_divided($a, $b, $scale, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected, (string)$dec->div($b, $scale));
        $this->assertSame($expected, (string)$dec->divide($b, $scale));
    }

    /**
     * @test
     */
    public function division_be_zero_throws_an_exception()
    {
        $this->expectException(DivisionByZeroError::class);

        $dec = new Decimal(1);

        $dec->divide(0);
    }

    /**
     * @test
     * @dataProvider increaseProvider
     */
    public function decimal_can_be_increased($input, $args, $expected)
    {
        $dec = new Decimal($input);

        $dec->increase(...$args);

        $this->assertSame($expected, (string)$dec);
    }

    /**
     * @test
     * @dataProvider decreaseProvider
     */
    public function decimal_can_be_decreased($input, $args, $expected)
    {
        $dec = new Decimal($input);

        $dec->decrease(...$args);

        $this->assertSame($expected, (string)$dec);
    }

    public function additionProvider()
    {
        return [
            ['0', '0', null, '0'],
            ['1', '10', null, '11'],
            ['1000', '10', null, '1010'],
            ['-10', '10', null, '0'],
            ['10', '-10', null, '0'],
            ['0.1', '1', null, '1.1'],
            ['0.1', '0.01', null, '0.11'],
            ['-0.001', '0.01', null, '0.009'],
            ['0', '0', 3, '0'],
            ['1000', '0.001', 3, '1000.001'],
            ['1000', '0.001', 0, '1000'],
            ['6.22e23', '-6.22e23', null, '0'],
            ['1e-10', '1e-10', null, '0.0000000002'],
            ['1e-10', '1e-10', 10, '0.0000000002'],
            ['1e-10', '1e-10', 9, '0'],
        ];
    }

    public function subtractionProvider()
    {
        return [
            ['0', '0', null, '0'],
            ['1', '10', null, '-9'],
            ['1000', '10', null, '990'],
            ['-10', '10', null, '-20'],
            ['10', '-10', null, '20'],
            ['10', '10', null, '0'],
            ['0.1', '1', null, '-0.9'],
            ['0.1', '0.01', null, '0.09'],
            ['-0.001', '0.01', null, '-0.011'],
            ['0', '0', 3, '0'],
            ['1000', '0.001', 3, '999.999'],
            ['1000', '0.001', 0, '999'],
            ['6.22e23', '-6.22e23', null, '1244000000000000000000000'],
            ['6.22e23', '6.22e23', null, '0'],
            ['1e-10', '1e-10', null, '0'],
            ['1e-10', '-1e-10', 10, '0.0000000002'],
            ['-1e-10', '1e-10', 10, '-0.0000000002'],
            ['1e-10', '-1e-10', 9, '0'],
        ];
    }

    public function multiplicationProvider()
    {
        return [
            ['0', '0', null, '0'],
            ['1', '10', null, '10'],
            ['15', 10, null, '150'],
            ['1000', '10', null, '10000'],
            ['-10', '10', null, '-100'],
            ['10', '-10', null, '-100'],
            ['10', '10', null, '100'],
            ['0.1', '1', null, '0.1'],
            ['0.1', '0.01', null, '0.001'],
            ['-0.001', '0.01', null, '-0.00001'],
            ['0', '0', 3, '0'],
            ['9', '0.001', 3, '0.009'],
            ['9', '0.001', 0, '0'],
            ['6.22e23', '2', null, '1244000000000000000000000'],
            ['6.22e23', '-1', null, '-622000000000000000000000'],
            ['1e-10', '28', null, '0.0000000028'],
            ['1e-10', '-1e-10', null, '-0.00000000000000000001'],
            ['1e-10', '-1e-10', 20, '-0.00000000000000000001'],
            ['1e-10', '-1e-10', 19, '0'],
        ];
    }

    public function divisionProvider()
    {
        return [
            ['0', '1', null, '0'],
            ['1', '1', null, '1'],
            ['15', 10, 1, '1.5'],
            ['0', '1e6', null, '0'],
            [1, 10, 1, '0.1'],
            ['1000', '10', null, '100'],
            ['-10', '10', null, '-1'],
            ['10', '-10', null, '-1'],
            ['10', '10', null, '1'],
            ['0.1', '1', null, '0.1'],
            ['0.1', '0.01', null, '10'],
            ['-0.001', '0.01', 1, '-0.1'],
            ['1', '3', 3, '0.333'],
            ['1', '3', 0, '0'],
            ['6.22e23', '2', null, '311000000000000000000000'],
            ['6.22e23', '-1', null, '-622000000000000000000000'],
            ['1e-10', 3, null, '0'],
            ['1e-10', 3, 11, '0.00000000003'],
            ['1e-10', 3, 12, '0.000000000033'],
        ];
    }

    public function increaseProvider()
    {
        return [
            [0, [], '0'],
            [1, [], '1'],
            [1, [0], '1'],
            [1, [0, 0, 0], '1'],
            [1, [1, 0, 1], '3'],
            [1, [[1, 0, 3]], '5'],
            [1, [[1, 0, 3], '0.1'], '5.1'],
            [1, [[1, 0, 3], ['0.1', '0.01']], '5.11'],
            [1, [-1], '0'],
            [0, ['0.1', '0.1', '0.1', '-0.3'], '0'],
            ['6.22e23', [1], '622000000000000000000001'],
            ['6.22e23', [-1], '621999999999999999999999'],
        ];
    }

    public function decreaseProvider()
    {
        return [
            [0, [], '0'],
            [1, [], '1'],
            [1, [0], '1'],
            [1, [0, 0, 0], '1'],
            [1, [1, 0, 1], '-1'],
            [1, [[1, 0, 3]], '-3'],
            [1, [[1, 0, 3], '0.1'], '-3.1'],
            [1, [[1, 0, 3], ['0.1', '0.01']], '-3.11'],
            [1, [-1], '2'],
            [0, ['0.1', '0.1', '0.1', '-0.3'], '0'],
            ['6.22e23', [1], '621999999999999999999999'],
            ['6.22e23', [-1], '622000000000000000000001'],
        ];
    }
}
