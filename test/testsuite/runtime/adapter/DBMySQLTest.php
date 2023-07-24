<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/DBAdapterTestAbstract.php';

/**
 * Tests the DbMySQL adapter
 *
 * @see        BookstoreDataPopulator
 * @author     William Durand
 * @package    runtime.adapter
 */
class DBMySQLTest extends DBAdapterTestAbstract
{
    public static function getConParams()
    {
        return [[['dsn' => 'dsn=my_dsn', 'settings' => ['charset' => ['value' => 'foobar']]]]];
    }

    /**
     * @dataProvider getConParams
     * @expectedException PropelException
     */
    public function testPrepareParamsThrowsException($conparams)
    {
        $this->expectException(PropelException::class);
        if (version_compare(PHP_VERSION, '5.3.6', '>=')) {
            $this->markTestSkipped('PHP_VERSION >= 5.3.6, no need to throw an exception.');
        }

        $db = new DBMySQL();
        $db->prepareParams($conparams);
    }

    /**
     * @dataProvider getConParams
     */
    public function testPrepareParams($conparams)
    {
        if (version_compare(PHP_VERSION, '5.3.6', '<')) {
            $this->markTestSkipped('PHP_VERSION < 5.3.6 will throw an exception.');
        }

        $db = new DBMySQL();
        $params = $db->prepareParams($conparams);

        $this->assertTrue(is_array($params));
        $this->assertEquals('dsn=my_dsn;charset=foobar', $params['dsn'], 'The given charset is in the DSN string');
        $this->assertArrayNotHasKey('charset', $params['settings'], 'The charset should be removed');
    }

    /**
     * @dataProvider getConParams
     */
    public function testNoSetNameQueryExecuted($conparams)
    {
        if (version_compare(PHP_VERSION, '5.3.6', '<')) {
            $this->markTestSkipped('PHP_VERSION < 5.3.6 will throw an exception.');
        }

        $db = new DBMySQL();
        $params = $db->prepareParams($conparams);

        $settings = [];
        if (isset($params['settings'])) {
            $settings = $params['settings'];
        }

        $db->initConnection($this->getPdoMock(), $settings);
    }

    protected function getPdoMock()
    {
        $con = $this
            ->getMockBuilder('mockPDO')
            ->getMock();

        $con
            ->expects($this->never())
            ->method('exec');

        return $con;
    }

    public function testQuotingIdentifiers()
    {
        $db = new DBMySQL();
        $this->assertEquals('`Book ISBN`', $db->quoteIdentifier('Book ISBN'));
    }

    /**
     * @dataProvider dataApplyLimit
     */
    public function testApplyLimit($offset, $limit, $expectedSql)
    {
        $sql = '';

        $db = new DBMySQL();
        $db->applyLimit($sql, $offset, $limit);

        $this->assertEquals($expectedSql, $sql, 'Generated SQL does not match expected SQL');
    }

    public function dataApplyLimit()
    {
        return [
            /*
               Offset & limit = 0
            */
            'Zero offset & limit' => ['offset'      => 0, 'limit'       => 0, 'expectedSql' => ''],
            /*
               Offset = 0
            */
            '32-bit limit' => ['offset'      => 0, 'limit'       => 4_294_967_295, 'expectedSql' => ' LIMIT 4294967295'],
            '32-bit limit as a string' => ['offset'      => 0, 'limit'       => '4294967295', 'expectedSql' => ' LIMIT 4294967295'],
            '64-bit limit' => ['offset'      => 0, 'limit'       => 9_223_372_036_854_775_807, 'expectedSql' => ' LIMIT 9223372036854775807'],
            '64-bit limit as a string' => ['offset'      => 0, 'limit'       => '9223372036854775807', 'expectedSql' => ' LIMIT 9223372036854775807'],
            'Float limit' => ['offset'      => 0, 'limit'       => 123.9, 'expectedSql' => ' LIMIT 123'],
            'Float limit as a string' => ['offset'      => 0, 'limit'       => '123.9', 'expectedSql' => ' LIMIT 123'],
            'Negative limit' => ['offset'      => 0, 'limit'       => -1, 'expectedSql' => ''],
            'Non-numeric string limit' => ['offset'      => 0, 'limit'       => 'foo', 'expectedSql' => ''],
            'SQL injected limit' => ['offset'      => 0, 'limit'       => '3;DROP TABLE abc', 'expectedSql' => ' LIMIT 3'],
            /*
               Limit = 0
            */
            '32-bit offset' => ['offset'      => 4_294_967_295, 'limit'       => 0, 'expectedSql' => ' LIMIT 4294967295, 18446744073709551615'],
            '32-bit offset as a string' => ['offset'      => '4294967295', 'limit'       => 0, 'expectedSql' => ' LIMIT 4294967295, 18446744073709551615'],
            '64-bit offset' => ['offset'      => 9_223_372_036_854_775_807, 'limit'       => 0, 'expectedSql' => ' LIMIT 9223372036854775807, 18446744073709551615'],
            '64-bit offset as a string' => ['offset'      => '9223372036854775807', 'limit'       => 0, 'expectedSql' => ' LIMIT 9223372036854775807, 18446744073709551615'],
            'Float offset' => ['offset'      => 123.9, 'limit'       => 0, 'expectedSql' => ' LIMIT 123, 18446744073709551615'],
            'Float offset as a string' => ['offset'      => '123.9', 'limit'       => 0, 'expectedSql' => ' LIMIT 123, 18446744073709551615'],
            'Negative offset' => ['offset'      => -1, 'limit'       => 0, 'expectedSql' => ''],
            'Non-numeric string offset' => ['offset'      => 'foo', 'limit'       => 0, 'expectedSql' => ''],
            'SQL injected offset' => ['offset'      => '3;DROP TABLE abc', 'limit'       => 0, 'expectedSql' => ' LIMIT 3, 18446744073709551615'],
            /*
               Offset & limit != 0
            */
            ['offset'      => 4_294_967_295, 'limit'       => 999, 'expectedSql' => ' LIMIT 4294967295, 999'],
            ['offset'      => '4294967295', 'limit'       => 999, 'expectedSql' => ' LIMIT 4294967295, 999'],
            ['offset'      => 9_223_372_036_854_775_807, 'limit'       => 999, 'expectedSql' => ' LIMIT 9223372036854775807, 999'],
            ['offset'      => '9223372036854775807', 'limit'       => 999, 'expectedSql' => ' LIMIT 9223372036854775807, 999'],
            ['offset'      => 123.9, 'limit'       => 999, 'expectedSql' => ' LIMIT 123, 999'],
            ['offset'      => '123.9', 'limit'       => 999, 'expectedSql' => ' LIMIT 123, 999'],
            ['offset'      => -1, 'limit'       => 999, 'expectedSql' => ' LIMIT 999'],
            ['offset'      => 'foo', 'limit'       => 999, 'expectedSql' => ' LIMIT 999'],
            ['offset'      => '3;DROP TABLE abc', 'limit'       => 999, 'expectedSql' => ' LIMIT 3, 999'],
        ];
    }
}

// See: http://stackoverflow.com/questions/3138946/mocking-the-pdo-object-using-phpunit
class mockPDO extends PDO
{
    public function __construct()
    {
    }
}
