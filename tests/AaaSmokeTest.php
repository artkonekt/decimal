<?php
/**
 * Contains the AaaSmokeTest class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-12-20
 *
 */


namespace Konekt\Decimal\Tests;

use PHPUnit\Framework\TestCase;

class AaaSmokeTest extends TestCase
{
    const MIN_PHP_VERSION = '7.0.0';

    /**
     * Very Basic smoke test case for testing against parse errors, etc
     *
     * @test
     */
    public function smoke()
    {
        $this->assertTrue(true);
    }

    /**
     * Test for minimum PHP version
     *
     * @depends smoke
     * @test
     */
    public function php_version_satisfies_requirements()
    {
        $this->assertFalse(version_compare(PHP_VERSION, self::MIN_PHP_VERSION, '<'),
            'PHP version ' . self::MIN_PHP_VERSION . ' or greater is required but only '
            . PHP_VERSION . ' found.');
    }
}
