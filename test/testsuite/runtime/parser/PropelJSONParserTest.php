<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../runtime/lib/parser/PropelParser.php';
require_once __DIR__ . '/../../../../runtime/lib/parser/PropelJSONParser.php';

/**
 * Test for PropelJSONParser class
 *
 * @author     Francois Zaninotto
 * @package    runtime.parser
 */
class PropelJSONParserTest extends \PHPUnit\Framework\TestCase
{
    public static function arrayJsonConversionDataProvider()
    {
        return [[[], '[]', 'empty array'], [[1, 2, 3], '[1,2,3]', 'regular array'], [[1, '2', 3], '[1,"2",3]', 'array with strings'], [[1, 2, [3, 4]], '[1,2,[3,4]]', 'nested arrays'], [['a' => 1, 'b' => 2], '{"a":1,"b":2}', 'associative array'], [['a' => 0, 'b' => null, 'c' => ''], '{"a":0,"b":null,"c":""}', 'associative array with empty values'], [['a' => 1, 'b' => 'bar'], '{"a":1,"b":"bar"}', 'associative array with strings'], [['a' => '<html><body><p style="width:30px;">Hello, World!</p></body></html>'], '{"a":"<html><body><p style=\"width:30px;\">Hello, World!<\/p><\/body><\/html>"}', 'associative array with code'], [['a' => 1, 'b' => ['foo' => 2]], '{"a":1,"b":{"foo":2}}', 'nested associative arrays'], [['Id' => 123, 'Title' => 'Pride and Prejudice', 'AuthorId' => 456, 'ISBN' => '0553213105', 'Author' => ['Id' => 456, 'FirstName' => 'Jane', 'LastName' => 'Austen']], '{"Id":123,"Title":"Pride and Prejudice","AuthorId":456,"ISBN":"0553213105","Author":{"Id":456,"FirstName":"Jane","LastName":"Austen"}}', 'array resulting from an object conversion'], [['a1' => 1, 'b2' => 2], '{"a1":1,"b2":2}', 'keys with numbers']];
    }

    /**
     * @dataProvider arrayJsonConversionDataProvider
     */
    public function testFromArray($arrayData, $jsonData, $type)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($jsonData, $parser->fromArray($arrayData), 'PropelJSONParser::fromArray() converts from ' . $type . ' correctly');
    }

    /**
     * @dataProvider arrayJsonConversionDataProvider
     */
    public function testToJSON($arrayData, $jsonData, $type)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($jsonData, $parser->toJSON($arrayData), 'PropelJSONParser::toJSON() converts from ' . $type . ' correctly');
    }

    /**
     * @dataProvider arrayJsonConversionDataProvider
     */
    public function testToArray($arrayData, $jsonData, $type)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($arrayData, $parser->toArray($jsonData), 'PropelJSONParser::toArray() converts to ' . $type . ' correctly');
    }

    /**
     * @dataProvider arrayJsonConversionDataProvider
     */
    public function testFromJSON($arrayData, $jsonData, $type)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($arrayData, $parser->fromJSON($jsonData), 'PropelJSONParser::fromJSON() converts to ' . $type . ' correctly');
    }

    public static function listToJSONDataProvider()
    {
        $list = ['book0' => ['Id' => 123, 'Title' => 'Pride and Prejudice', 'AuthorId' => 456, 'ISBN' => '0553213105', 'Author' => ['Id' => 456, 'FirstName' => 'Jane', 'LastName' => 'Austen']], 'book1' => ['Id' => 82, 'Title' => 'Anna Karenina', 'AuthorId' => 543, 'ISBN' => '0143035002', 'Author' => ['Id' => 543, 'FirstName' => 'Leo', 'LastName' => 'Tolstoi']], 'book2' => ['Id' => 567, 'Title' => 'War and Peace', 'AuthorId' => 543, 'ISBN' => '067003469X', 'Author' => ['Id' => 543, 'FirstName' => 'Leo', 'LastName' => 'Tolstoi']]];
        $json = <<<EOF
{"book0":{"Id":123,"Title":"Pride and Prejudice","AuthorId":456,"ISBN":"0553213105","Author":{"Id":456,"FirstName":"Jane","LastName":"Austen"}},"book1":{"Id":82,"Title":"Anna Karenina","AuthorId":543,"ISBN":"0143035002","Author":{"Id":543,"FirstName":"Leo","LastName":"Tolstoi"}},"book2":{"Id":567,"Title":"War and Peace","AuthorId":543,"ISBN":"067003469X","Author":{"Id":543,"FirstName":"Leo","LastName":"Tolstoi"}}}
EOF;

        return [[$list, $json]];
    }

    /**
     * @dataProvider listToJSONDataProvider
     */
    public function testListToJSON($list, $json)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($json, $parser->toJSON($list));
    }

    /**
     * @dataProvider listToJSONDataProvider
     */
    public function testJSONToList($list, $json)
    {
        $parser = new PropelJSONParser();
        $this->assertEquals($list, $parser->fromJSON($json));
    }
}
