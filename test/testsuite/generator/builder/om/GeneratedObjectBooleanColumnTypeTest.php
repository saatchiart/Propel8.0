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
 * Tests the generated objects for boolean column types accessor & mutator
 *
 * @author     Francois Zaninotto
 * @package    generator.builder.om
 */
class GeneratedObjectBooleanColumnTypeTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        if (!class_exists('ComplexColumnTypeEntity4')) {
            $schema = <<<EOF
<database name="generated_object_complex_type_test_4">
    <table name="complex_column_type_entity_4">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="BOOLEAN" />
        <column name="true_bar" type="BOOLEAN" defaultValue="true" />
        <column name="false_bar" type="BOOLEAN" defaultValue="false" />
    </table>
</database>
EOF;
            PropelQuickBuilder::buildSchema($schema);
        }
    }

    public function providerForSetter()
    {
        return [[true, true], [false, false], ['true', true], ['false', false], [1, true], [0, false], ['1', true], ['0', false], ['on', true], ['off', false], ['yes', true], ['no', false], ['y', true], ['n', false], ['Y', true], ['N', false], ['+', true], ['-', false], ['', false]];
    }

    /**
     * @dataProvider providerForSetter
     */
    public function testSetterBooleanValue($value, $expected)
    {
        $e = new ComplexColumnTypeEntity4();
        $e->setBar($value);
        if ($expected) {
            $this->assertTrue($e->getBar());
        } else {
            $this->assertFalse($e->getBar());
        }
    }

    public function testDefaultValue()
    {
        $e = new ComplexColumnTypeEntity4();
        $this->assertNull($e->getBar());
        $this->assertTrue($e->getTrueBar());
        $this->assertFalse($e->getFalseBar());
    }

}
