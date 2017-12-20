<?php
/**
 * Contains the BasicTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal\Tests;


use InvalidArgumentException;
use Konekt\Decimal\Decimal;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateDecimalsTest extends TestCase
{
    /**
     * @test
     * @dataProvider createWithValuesProvider
     */
    public function it_can_be_created_with_values($value, $expected)
    {
        $d = new Decimal($value);

        $this->assertInstanceOf(Decimal::class, $d);
        $this->assertSame($expected, (string)$d);
    }

    /**
     * @test
     */
    public function it_can_not_be_created_with_an_invalid_value()
    {
        $this->expectException(InvalidArgumentException::class);

        new Decimal('');
    }

    /**
     * @test
     * @dataProvider createWithValuesProvider
     */
    public function instances_can_be_made_with_make_factory_method($input, $expected)
    {
        $d = Decimal::make($input);

        $this->assertInstanceOf(Decimal::class, $d);
        $this->assertSame($expected, (string)$d);
    }

    /**
     * @test
     * @dataProvider createWithValuesProvider
     */
    public function decimals_can_be_copied($input, $expected)
    {
        $src  = new Decimal($input);
        $dest = new Decimal;

        $dest->copy($src);

        $this->assertTrue($dest->eq($src));
        $this->assertSame($expected, (string)$dest);
    }


    /**
     * @test
     * @dataProvider cleanProvider
     */
    public function it_can_clean_input_string_arguments($input, $expected)
    {
        $this->assertSame($expected, Decimal::cleanValue($input));
    }

    /**
     * @test
     */
    public function clean_value_method_throws_an_exception_when_the_number_cant_be_parsed()
    {
        $this->expectException(InvalidArgumentException::class);

        Decimal::cleanValue('not a number');
    }

    /**
     * @test
     * @dataProvider scaleValidProvider
     */
    public function scale_can_only_be_a_positive_non_zero_number($scale, $expected)
    {
        $this->assertSame($expected, Decimal::scaleValid($scale));
    }

    /**
     * @test
     */
    public function decimal_with_zero_value_can_be_created_with_dedicated_factory_method()
    {
        $d = Decimal::zero();

        $this->assertInstanceOf(Decimal::class, $d);
        $this->assertSame('0', (string)$d);
    }

    /**
     * @test
     */
    public function decimal_with_one_value_can_be_created_with_dedicated_factory_method()
    {
        $d = Decimal::one();

        $this->assertInstanceOf(Decimal::class, $d);
        $this->assertSame('1', (string)$d);
    }


    function createWithValuesProvider()
    {
        return [
            [50, '50'],
            [-25000, '-25000'],
            [0.00001, '0.00001'],
            ['-5.000067', '-5.000067'],
            ['0000005', '5'],
            ['6.22e23', '622000000000000000000000'],
            ['0000', '0'],
        ];
    }

    public function cleanProvider()
    {
        return [
            ['0', '0'],
            [0, '0'],
            [0.2, '0.2'],
            [-0.1, '-0.1'],
            ['6.22e23', '6.22e23'],
            ['6.22 E 23', '6.22E23'],
            [' 1 ', '1'],
            ['=1', '1'],
            ['abc1', '1'],
        ];
    }

    public function scaleValidProvider()
    {
        return [
            [null, false],
            [0, true],
            [1, true],
            [2, true],
            [-1, false],
            [-2, false],
            [7.5, false],
            ['', false],
            [new stdClass, false],
        ];
    }
}
