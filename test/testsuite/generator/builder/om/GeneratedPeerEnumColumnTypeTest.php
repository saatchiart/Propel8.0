<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../../generator/lib/util/PropelQuickBuilder.php';
require_once __DIR__ . '/../../../../../runtime/lib/Propel.php';

/**
 * Tests the generated Peer classes for enum column type constants
 *
 * @author     Francois Zaninotto
 * @package    generator.builder.om
 */
class GeneratedPeerEnumColumnTypeTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        if (!class_exists('ComplexColumnTypeEntity103Peer')) {
            $schema = <<<EOF
<database name="generated_object_complex_type_test_103">
    <table name="complex_column_type_entity_103">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="ENUM" valueSet="foo, bar, baz, 1, 4,(, foo bar " />
    </table>
</database>
EOF;
            PropelQuickBuilder::buildSchema($schema);
        }
    }

    public function valueSetConstantProvider()
    {
        return [['ComplexColumnTypeEntity103Peer::BAR_FOO', 'foo'], ['ComplexColumnTypeEntity103Peer::BAR_BAR', 'bar'], ['ComplexColumnTypeEntity103Peer::BAR_BAZ', 'baz'], ['ComplexColumnTypeEntity103Peer::BAR_1', '1'], ['ComplexColumnTypeEntity103Peer::BAR_4', '4'], ['ComplexColumnTypeEntity103Peer::BAR__', '('], ['ComplexColumnTypeEntity103Peer::BAR_FOO_BAR', 'foo bar']];
    }

    /**
     * @dataProvider valueSetConstantProvider
     */
    public function testValueSetConstants($constantName, $value)
    {
        $this->assertTrue(defined($constantName));
        $this->assertEquals($value, constant($constantName));
    }

    public function testGetValueSets()
    {
        $expected = [ComplexColumnTypeEntity103Peer::BAR => ['foo', 'bar', 'baz', '1', '4', '(', 'foo bar']];
        $this->assertEquals($expected, ComplexColumnTypeEntity103Peer::getValueSets());
    }

    public function testGetValueSet()
    {
        $expected = ['foo', 'bar', 'baz', '1', '4', '(', 'foo bar'];
        $this->assertEquals($expected, ComplexColumnTypeEntity103Peer::getValueSet(ComplexColumnTypeEntity103Peer::BAR));
    }

    /**
     * @expectedException PropelException
     */
    public function testGetValueSetInvalidColumn()
    {
        $this->expectException(PropelException::class);
        ComplexColumnTypeEntity103Peer::getValueSet(ComplexColumnTypeEntity103Peer::ID);
    }

    public function testGetSqlValueForEnum()
    {
        $this->assertEquals(0, ComplexColumnTypeEntity103Peer::getSqlValueForEnum(ComplexColumnTypeEntity103Peer::BAR, ComplexColumnTypeEntity103Peer::BAR_FOO));
        $this->assertEquals(1, ComplexColumnTypeEntity103Peer::getSqlValueForEnum(ComplexColumnTypeEntity103Peer::BAR, ComplexColumnTypeEntity103Peer::BAR_BAR));
        $this->assertEquals(2, ComplexColumnTypeEntity103Peer::getSqlValueForEnum(ComplexColumnTypeEntity103Peer::BAR, ComplexColumnTypeEntity103Peer::BAR_BAZ));
        $this->assertEquals(6, ComplexColumnTypeEntity103Peer::getSqlValueForEnum(ComplexColumnTypeEntity103Peer::BAR, ComplexColumnTypeEntity103Peer::BAR_FOO_BAR));
    }

    public function testEnumSqlGetters()
    {
        $this->assertEquals(0, ComplexColumnTypeEntity103Peer::getBarSqlValue(ComplexColumnTypeEntity103Peer::BAR_FOO));
        $this->assertEquals(1, ComplexColumnTypeEntity103Peer::getBarSqlValue(ComplexColumnTypeEntity103Peer::BAR_BAR));
        $this->assertEquals(2, ComplexColumnTypeEntity103Peer::getBarSqlValue(ComplexColumnTypeEntity103Peer::BAR_BAZ));
        $this->assertEquals(6, ComplexColumnTypeEntity103Peer::getBarSqlValue(ComplexColumnTypeEntity103Peer::BAR_FOO_BAR));
    }
}
