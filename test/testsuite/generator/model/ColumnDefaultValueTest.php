<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/model/ColumnDefaultValue.php';

/**
 * Tests for ColumnDefaultValue class.
 *
 * @version    $Revision$
 * @package    generator.model
 */
class ColumnDefaultValueTest extends \PHPUnit\Framework\TestCase
{
    public function equalsProvider()
    {
        return [[new ColumnDefaultValue('foo', 'bar'), new ColumnDefaultValue('foo', 'bar'), true], [new ColumnDefaultValue('foo', 'bar'), new ColumnDefaultValue('foo1', 'bar'), false], [new ColumnDefaultValue('foo', 'bar'), new ColumnDefaultValue('foo', 'bar1'), false], [new ColumnDefaultValue('current_timestamp', 'bar'), new ColumnDefaultValue('now()', 'bar'), true], [new ColumnDefaultValue('current_timestamp', 'bar'), new ColumnDefaultValue('now()', 'bar1'), false]];
    }

    /**
     * @dataProvider equalsProvider
     */
    public function testEquals($def1, $def2, $test)
    {
        if ($test) {
            $this->assertTrue($def1->equals($def2));
        } else {
            $this->assertFalse($def1->equals($def2));
        }
    }
}
