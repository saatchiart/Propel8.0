<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/model/XMLElement.php';

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class XMLElementTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider providerForGetDefaultValueForArray
     */
    public function testGetDefaultValueForArray($value, $expected)
    {
        $xmlElement = new TestableXmlElement();
        $this->assertEquals($expected, $xmlElement->getDefaultValueForArray($value));
    }

    public static function providerForGetDefaultValueForArray()
    {
        return [['', null], [null, null], ['FOO', '||FOO||'], ['FOO, BAR', '||FOO | BAR||'], ['FOO , BAR', '||FOO | BAR||'], ['FOO,BAR', '||FOO | BAR||'], [' ', null], [', ', null]];
    }
}

class TestableXmlElement extends XMLElement
{
    public function getDefaultValueForArray($value)
    {
        return parent::getDefaultValueForArray($value);
    }

    public function appendXml(DOMNode $node)
    {
    }

    protected function setupObject()
    {
    }
}
