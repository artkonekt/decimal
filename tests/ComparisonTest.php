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


use Konekt\Decimal\Decimal;
use PHPUnit\Framework\TestCase;

class ComparisonTest extends TestCase
{
    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_be_compared($a, $b, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected, $dec->compare($b));
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_be_checked_for_equality($a, $b, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected == 0, $dec->equals($b));
        $this->assertSame($expected == 0, $dec->eq($b));
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_tell_if_one_of_them_is_greater_than_the_other($a, $b, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected > 0, $dec->greaterThan($b));
        $this->assertSame($expected > 0, $dec->gt($b));
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_tell_if_one_of_them_is_less_than_the_other($a, $b, $expected)
    {
        $dec = new Decimal($a);

        $this->assertSame($expected < 0, $dec->lessThan($b));
        $this->assertSame($expected < 0, $dec->lt($b));
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_tell_if_one_of_them_is_greater_or_equal_than_the_other(
        $a,
        $b,
        $expected
    ) {
        $dec = new Decimal($a);

        $this->assertSame($expected >= 0, $dec->ge($b));
    }

    /**
     * @test
     * @dataProvider compareProvider
     */
    public function decimals_can_tell_if_one_of_them_is_less_or_equal_than_the_other(
        $a,
        $b,
        $expected
    ) {
        $dec = new Decimal($a);

        $this->assertSame($expected <= 0, $dec->le($b));
    }

    /**
     * @test
     * @dataProvider compareZeroProvider
     */
    public function decimal_can_tell_if_it_is_zero($input, $expected)
    {
        $dec = new Decimal($input);

        $this->assertSame($expected == 0, $dec->isZero());
    }

    /**
     * @test
     * @dataProvider compareZeroProvider
     */
    public function decimal_can_tell_if_it_is_positive($input, $expected)
    {
        $dec = new Decimal($input);

        $this->assertSame($expected > 0, $dec->positive());
    }

    /**
     * @test
     * @dataProvider compareZeroProvider
     */
    public function decimal_can_tell_if_it_is_negative($input, $expected)
    {
        $dec = new Decimal($input);

        $this->assertSame($expected < 0, $dec->negative());
    }


    public function compareProvider()
    {
        return [
            [0, 0, 0],
            [1, 0, 1],
            [-1, 0, -1],
            ['12.375', '12.375', 0],
            ['12.374', '12.375', -1],
            ['12.376', '12.375', 1],
            ['6.22e23', '6.22e23', 0],
            ['1e-10', '1e-9', -1],
        ];
    }

    public function compareZeroProvider()
    {
        return [
            [0, 0],
            [1, 1],
            [-1, -1],
            [0.0, 0],
            ['0', 0],
            ['1', 1],
            ['-1', -1],
            ['00000', 0],
            ['  0.0   ', 0],
            ['0.00001', 1],
            ['1e-20', 1],
            ['-1e-20', -1],
        ];
    }
}
