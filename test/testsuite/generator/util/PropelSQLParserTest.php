<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/util/PropelSQLParser.php';

/**
 *
 * @package    generator.util
 */
class PropelSQLParserTest extends \PHPUnit\Framework\TestCase
{
    public function stripSqlCommentsDataProvider()
    {
        return [['', ''], ['foo with no comments', 'foo with no comments'], ['foo with // inline comments', 'foo with // inline comments'], ["foo with\n// comments", "foo with\n"], [" // comments preceded by blank\nfoo", "foo"], ["// slash-style comments\nfoo", "foo"], ["-- dash-style comments\nfoo", "foo"], ["# hash-style comments\nfoo", "foo"], ["/* c-style comments*/\nfoo", "\nfoo"], ["foo with\n// comments\nwith foo", "foo with\nwith foo"], ["// comments with\nfoo with\n// comments\nwith foo", "foo with\nwith foo"]];
    }

    /**
     * @dataProvider stripSqlCommentsDataProvider
     */
    public function testStripSQLComments($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $parser->stripSQLCommentLines();
        $this->assertEquals($output, $parser->getSQL());
    }

    public function convertLineFeedsToUnixStyleDataProvider()
    {
        return [['', ''], ["foo bar", "foo bar"], ["foo\nbar", "foo\nbar"], ["foo\rbar", "foo\nbar"], ["foo\r\nbar", "foo\nbar"], ["foo\r\nbar\rbaz\nbiz\r\n", "foo\nbar\nbaz\nbiz\n"]];
    }

    /**
     * @dataProvider convertLineFeedsToUnixStyleDataProvider
     */
    public function testConvertLineFeedsToUnixStyle($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $parser->convertLineFeedsToUnixStyle();
        $this->assertEquals($output, $parser->getSQL());
    }

    public function explodeIntoStatementsDataProvider()
    {
        return [['', []], ['foo', ['foo']], ['foo;', ['foo']], ['foo; ', ['foo']], ['foo;bar', ['foo', 'bar']], ['foo;bar;', ['foo', 'bar']], ["f\no\no;\nb\nar\n;", ["f\no\no", "b\nar"]], ['foo";"bar;baz', ['foo";"bar', 'baz']], ['foo\';\'bar;baz', ['foo\';\'bar', 'baz']], ['foo"\";"bar;', ['foo"\";"bar']]];
    }
    /**
     * @dataProvider explodeIntoStatementsDataProvider
     */
    public function testExplodeIntoStatements($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $this->assertEquals($output, $parser->explodeIntoStatements());
    }

    public function testDelimiterOneCharacter()
    {
        $parser = new PropelSQLParser();
        $parser->setSQL('DELIMITER |');
        $this->assertEquals([], $parser->explodeIntoStatements());
    }

    public function testDelimiterMultipleCharacters()
    {
        $parser = new PropelSQLParser();
        $parser->setSQL('DELIMITER ||');
        $this->assertEquals([], $parser->explodeIntoStatements());

        $parser = new PropelSQLParser();
        $parser->setSQL('DELIMITER |||');
        $this->assertEquals([], $parser->explodeIntoStatements());

        $parser = new PropelSQLParser();
        $parser->setSQL('DELIMITER ////');
        $this->assertEquals([], $parser->explodeIntoStatements());
    }

    public function singleDelimiterExplodeIntoStatementsDataProvider()
    {
        return [["delimiter |", []], ["DELIMITER |", []], ["foo;\nDELIMITER |", ['foo']], ["foo;\nDELIMITER |\nbar", ['foo', 'bar']], ["foo;\nDELIMITER |\nbar;", ['foo', 'bar;']], ["foo;\nDELIMITER |\nbar;\nbaz;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER |\nbar;\nbaz;\nDELIMITER ;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER |\nbar;\nbaz;\nDELIMITER ;\nqux", ['foo', "bar;\nbaz;", 'qux']], ["foo;\nDELIMITER |\nbar;\nbaz;\nDELIMITER ;\nqux;", ['foo', "bar;\nbaz;", 'qux']], ["DELIMITER |\n".'foo"|"bar;'."\nDELIMITER ;\nbaz", ['foo"|"bar;', 'baz']], ["DELIMITER |\n".'foo\'|\'bar;'."\nDELIMITER ;\nbaz", ['foo\'|\'bar;', 'baz']], ["DELIMITER |\n".'foo"\"|"bar;'."\nDELIMITER ;\nbaz", ['foo"\"|"bar;', 'baz']]];
    }

    /**
     * @dataProvider singleDelimiterExplodeIntoStatementsDataProvider
     */
    public function testSingleDelimiterExplodeIntoStatements($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $this->assertEquals($output, $parser->explodeIntoStatements());
    }

    public function twoCharDelimiterExplodeIntoStatementsDataProvider()
    {
        return [["delimiter ||", []], ["DELIMITER ||", []], ["foo;\nDELIMITER ||", ['foo']], ["foo;\nDELIMITER ||\nbar", ['foo', 'bar']], ["foo;\nDELIMITER ||\nbar;", ['foo', 'bar;']], ["foo;\nDELIMITER ||\nbar;\nbaz;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER ||\nbar;\nbaz;\nDELIMITER ;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER ||\nbar;\nbaz;\nDELIMITER ;\nqux", ['foo', "bar;\nbaz;", 'qux']], ["foo;\nDELIMITER ||\nbar;\nbaz;\nDELIMITER ;\nqux;", ['foo', "bar;\nbaz;", 'qux']], ["DELIMITER ||\n".'foo"||"bar;'."\nDELIMITER ;\nbaz", ['foo"||"bar;', 'baz']], ["DELIMITER ||\n".'foo\'||\'bar;'."\nDELIMITER ;\nbaz", ['foo\'||\'bar;', 'baz']], ["DELIMITER ||\n".'foo"\"||"bar;'."\nDELIMITER ;\nbaz", ['foo"\"||"bar;', 'baz']]];
    }

    /**
     * @dataProvider twoCharDelimiterExplodeIntoStatementsDataProvider
     */
    public function testTwoCharDelimiterExplodeIntoStatements($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $this->assertEquals($output, $parser->explodeIntoStatements());
    }

    public function threeCharDelimiterExplodeIntoStatementsDataProvider()
    {
        return [["delimiter |||", []], ["DELIMITER |||", []], ["foo;\nDELIMITER |||", ['foo']], ["foo;\nDELIMITER |||\nbar", ['foo', 'bar']], ["foo;\nDELIMITER |||\nbar;", ['foo', 'bar;']], ["foo;\nDELIMITER |||\nbar;\nbaz;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER |||\nbar;\nbaz;\nDELIMITER ;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER |||\nbar;\nbaz;\nDELIMITER ;\nqux", ['foo', "bar;\nbaz;", 'qux']], ["foo;\nDELIMITER |||\nbar;\nbaz;\nDELIMITER ;\nqux;", ['foo', "bar;\nbaz;", 'qux']], ["DELIMITER |||\n".'foo"|||"bar;'."\nDELIMITER ;\nbaz", ['foo"|||"bar;', 'baz']], ["DELIMITER |||\n".'foo\'|||\'bar;'."\nDELIMITER ;\nbaz", ['foo\'|||\'bar;', 'baz']], ["DELIMITER |||\n".'foo"\"|||"bar;'."\nDELIMITER ;\nbaz", ['foo"\"|||"bar;', 'baz']]];
    }

    /**
     * @dataProvider threeCharDelimiterExplodeIntoStatementsDataProvider
     */
    public function testThreeCharDelimiterExplodeIntoStatements($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $this->assertEquals($output, $parser->explodeIntoStatements());
    }

    public function fourCharDelimiterExplodeIntoStatementsDataProvider()
    {
        return [["delimiter ////", []], ["DELIMITER ////", []], ["foo;\nDELIMITER ////", ['foo']], ["foo;\nDELIMITER ////\nbar", ['foo', 'bar']], ["foo;\nDELIMITER ////\nbar;", ['foo', 'bar;']], ["foo;\nDELIMITER ////\nbar;\nbaz;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER ////\nbar;\nbaz;\nDELIMITER ;", ['foo', "bar;\nbaz;"]], ["foo;\nDELIMITER ////\nbar;\nbaz;\nDELIMITER ;\nqux", ['foo', "bar;\nbaz;", 'qux']], ["foo;\nDELIMITER ////\nbar;\nbaz;\nDELIMITER ;\nqux;", ['foo', "bar;\nbaz;", 'qux']], ["DELIMITER ////\n".'foo"////"bar;'."\nDELIMITER ;\nbaz", ['foo"////"bar;', 'baz']], ["DELIMITER ////\n".'foo\'////\'bar;'."\nDELIMITER ;\nbaz", ['foo\'////\'bar;', 'baz']], ["DELIMITER ////\n".'foo"\"////"bar;'."\nDELIMITER ;\nbaz", ['foo"\"////"bar;', 'baz']]];
    }

    /**
     * @dataProvider fourCharDelimiterExplodeIntoStatementsDataProvider
     */
    public function testFourCharDelimiterExplodeIntoStatements($input, $output)
    {
        $parser = new PropelSQLParser();
        $parser->setSQL($input);
        $this->assertEquals($output, $parser->explodeIntoStatements());
    }
}
