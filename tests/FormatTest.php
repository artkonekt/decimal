<?php
/**
 * Contains the FormatTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal\Tests;


use Konekt\Decimal\Decimal;
use Konekt\Decimal\Formatter;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    /**
     * @test
     * @dataProvider formatProvider
     */
    public function string_representation_can_be_formatted($input, $args, $expected)
    {
        $d = new Decimal($input);

        $this->assertSame($expected, $d->format(...$args));
    }

    /**
     * @test
     * @dataProvider formaterClassProvider
     */
    public function formatter_class_does_its_jobs_sorry_have_no_better_name_idea_shrug($value, $args, $expected)
    {
        $formatter = new Formatter(...$args);
        $result    = $formatter->format($value);

        $this->assertSame($expected, $result);
    }

    public function formatProvider()
    {
        return [
            [0, [], '0'],
            [1, [], '1'],
            [-1, [], '-1'],
            ['12.375', [], '12.375'],
            ['12.375', [4], '12.3750'],
            ['12.375', [3], '12.375'],
            ['12.375', [2], '12.38'],
            ['12.375', [1], '12.4'],
            ['12.375', [0], '12'],
            [-0.7, [null], '-0.7'],
            [0.7, [0], '1'],
            ['6.22e23', [null], '622000000000000000000000'],
            ['6.22e23', [null, ','], '622,000,000,000,000,000,000,000'],
            ['6.22e23', [null, ' '], '622 000 000 000 000 000 000 000'],
            ['6.22e23', [2, ','], '622,000,000,000,000,000,000,000.00'],
            ['6.22e23', [2, '.', ','], '622.000.000.000.000.000.000.000,00'],
            ['-6.22e23', [null, ','], '-622,000,000,000,000,000,000,000'],
            ['1e-10', [], '0.0000000001'],
            ['-1e-10', [], '-0.0000000001'],
            ['-1e-10', [9], '-0.000000000'],
        ];
    }


    public function formaterClassProvider()
    {
        return [
            [0, [], '0'],
            [1, [], '1'],
            [-1, [], '-1'],
            ['', [], '0'],
            [null, [], '0'],
            [new Decimal, [], '0'],
            ['12.375', [], '12.375'],
            ['12.375', [4], '12.3750'],
            ['12.375', [3], '12.375'],
            ['12.375', [2], '12.38'],
            ['12.375', [1], '12.4'],
            ['12.375', [0], '12'],
            [-0.7, [null], '-0.7'],
            [0.7, [0], '1'],
            ['6.22e23', [null], '622000000000000000000000'],
            ['6.22e23', [null, ','], '622,000,000,000,000,000,000,000'],
            ['6.22e23', [null, ' '], '622 000 000 000 000 000 000 000'],
            ['6.22e23', [2, ','], '622,000,000,000,000,000,000,000.00'],
            ['6.22e23', [2, '.', ','], '622.000.000.000.000.000.000.000,00'],
            ['-6.22e23', [null, ','], '-622,000,000,000,000,000,000,000'],
            ['1e-10', [], '0.0000000001'],
            ['-1e-10', [], '-0.0000000001'],
            ['-1e-10', [9], '-0.000000000'],
        ];
    }


}
