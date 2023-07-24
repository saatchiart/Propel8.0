<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../runtime/lib/Propel.php';
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/../../../fixtures/schemas/build/classes'));

/**
 * Bse class for tests on the schemas schema
 */
abstract class SchemasTestBase extends \PHPUnit\Framework\TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        if (!file_exists(__DIR__ . '/../../../fixtures/schemas/build/conf/bookstore-conf.php')) {
            $this->markTestSkipped('You must build the schemas project fot this tests to run');
        }
        Propel::init(__DIR__ . '/../../../fixtures/schemas/build/conf/bookstore-conf.php');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Propel::init(__DIR__ . '/../../../fixtures/bookstore/build/conf/bookstore-conf.php');
    }
}
