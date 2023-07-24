<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/model/PhpNameGenerator.php';

/**
 * Tests for PhpNameGenerator
 *
 * @author     <a href="mailto:mpoeschl@marmot.at>Martin Poeschl</a>
 * @version    $Revision$
 * @package    generator.model
 */
class PhpNameGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public static function phpnameMethodDataProvider()
    {
        return [['foo', 'Foo'], ['Foo', 'Foo'], ['FOO', 'FOO'], ['123', '123'], ['foo_bar', 'FooBar'], ['bar_1', 'Bar1'], ['bar_0', 'Bar0'], ['my_CLASS_name', 'MyCLASSName']];
    }

    /**
     * @dataProvider phpnameMethodDataProvider
     */
    public function testPhpnameMethod($input, $output)
    {
        $generator = new TestablePhpNameGenerator();
        $this->assertEquals($output, $generator->phpnameMethod($input));
    }

    public static function underscoreMethodDataProvider()
    {
        return [['foo', 'Foo'], ['Foo', 'Foo'], ['Foo', 'Foo'], ['123', '123'], ['foo_bar', 'FooBar'], ['bar_1', 'Bar1'], ['bar_0', 'Bar0'], ['my_CLASS_name', 'MyClassName']];
    }

    /**
     * @dataProvider underscoreMethodDataProvider
     */
    public function testUnderscoreMethod($input, $output)
    {
        $generator = new TestablePhpNameGenerator();
        $this->assertEquals($output, $generator->underscoreMethod($input));
    }

}

class TestablePhpNameGenerator extends PhpNameGenerator
{
    public function phpnameMethod($schemaName)
    {
        return parent::phpnameMethod($schemaName);
    }

    public function underscoreMethod($schemaName)
    {
        return parent::underscoreMethod($schemaName);
    }
}
