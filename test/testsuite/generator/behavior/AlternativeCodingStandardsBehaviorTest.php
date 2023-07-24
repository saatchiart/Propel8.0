<?php

/*
 *	$Id: TimestampableBehaviorTest.php 2035 2010-11-14 17:54:27Z francois $
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/model/Behavior.php';
require_once __DIR__ . '/../../../../generator/lib/behavior/AlternativeCodingStandardsBehavior.php';

/**
 * Tests for TimestampableBehavior class
 *
 * @author     François Zaninotto
 * @version    $Revision$
 * @package    generator.behavior
 */
class AlternativeCodingStandardsBehaviorTest extends \PHPUnit\Framework\TestCase
{
    public function convertBracketsNewlineDataProvider()
    {
        return [["class Foo {
}", "class Foo
{
}"], ["if (true) {
}", "if (true)
{
}"], ["} else {
}", "}
else
{
}"], ["foreach (\$i as \$j) {
}", "foreach (\$i as \$j)
{
}"]];
    }

    /**
     * @dataProvider convertBracketsNewlineDataProvider
     */
    public function testConvertBracketsNewline($input, $output)
    {
        $b = new TestableAlternativeCodingStandardsBehavior();
        $b->filter($input);
        $this->assertEquals($output, $input);
    }
}

class TestableAlternativeCodingStandardsBehavior extends AlternativeCodingStandardsBehavior
{
    public function filter(&$script)
    {
        return parent::filter($script);
    }
}
