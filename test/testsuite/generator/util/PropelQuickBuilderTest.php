<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

require_once __DIR__ . '/../../../../generator/lib/util/PropelQuickBuilder.php';
require_once __DIR__ . '/../../../../runtime/lib/Propel.php';

/**
 *
 * @package    generator.util
 */
class PropelQuickBuilderTest extends \PHPUnit\Framework\TestCase
{
    public function testGetPlatform()
    {
        require_once __DIR__ . '/../../../../generator/lib/platform/MysqlPlatform.php';
        $builder = new PropelQuickBuilder();
        $builder->setPlatform(new MysqlPlatform());
        $this->assertTrue($builder->getPLatform() instanceof MysqlPlatform);
        $builder = new PropelQuickBuilder();
        $this->assertTrue($builder->getPLatform() instanceof SqlitePlatform);
    }

    public function simpleSchemaProvider()
    {
        $schema = <<<EOF
<database name="test_quick_build_2">
    <table name="quick_build_foo_1">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="INTEGER" />
    </table>
</database>
EOF;
        $builder = new PropelQuickBuilder();
        $builder->setSchema($schema);

        return [[$builder]];
    }

    /**
     * @dataProvider simpleSchemaProvider
     */
    public function testGetDatabase($builder)
    {
        $database = $builder->getDatabase();
        $this->assertEquals('test_quick_build_2', $database->getName());
        $this->assertEquals(1, is_countable($database->getTables()) ? count($database->getTables()) : 0);
        $this->assertEquals(2, is_countable($database->getTable('quick_build_foo_1')->getColumns()) ? count($database->getTable('quick_build_foo_1')->getColumns()) : 0);
    }

    /**
     * @dataProvider simpleSchemaProvider
     */
    public function testGetSQL($builder)
    {
        $expected = <<<EOF

-----------------------------------------------------------------------
-- quick_build_foo_1
-----------------------------------------------------------------------

DROP TABLE IF EXISTS [quick_build_foo_1];

CREATE TABLE [quick_build_foo_1]
(
    [id] INTEGER NOT NULL PRIMARY KEY,
    [bar] INTEGER
);

EOF;
        $this->assertEquals($expected, $builder->getSQL());
    }

    /**
     * @dataProvider simpleSchemaProvider
     */
    public function testGetClasses($builder)
    {
        $script = $builder->getClasses();
        $this->assertStringContainsString('class QuickBuildFoo1 extends BaseQuickBuildFoo1', $script);
        $this->assertStringContainsString('class QuickBuildFoo1Peer extends BaseQuickBuildFoo1Peer', $script);
        $this->assertStringContainsString('class QuickBuildFoo1Query extends BaseQuickBuildFoo1Query', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1 extends BaseObject', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1Peer', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1Query extends ModelCriteria', $script);
    }

    /**
     * @dataProvider simpleSchemaProvider
     */
    public function testBuildClasses($builder)
    {
        $builder->buildClasses();
        $foo = new QuickBuildFoo1();
        $this->assertTrue($foo instanceof BaseObject);
        $this->assertTrue(QuickBuildFoo1Peer::getTableMap() instanceof QuickBuildFoo1TableMap);
    }

    /**
     * @dataProvider simpleSchemaProvider
     */
    public function testGetClassesLimitedClassTargets($builder)
    {
        $script = $builder->getClasses(['tablemap', 'peer', 'object', 'query']);
        $this->assertStringNotContainsString('class QuickBuildFoo1 extends BaseQuickBuildFoo1', $script);
        $this->assertStringNotContainsString('class QuickBuildFoo1Peer extends BaseQuickBuildFoo1Peer', $script);
        $this->assertStringNotContainsString('class QuickBuildFoo1Query extends BaseQuickBuildFoo1Query', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1 extends BaseObject', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1Peer', $script);
        $this->assertStringContainsString('class BaseQuickBuildFoo1Query extends ModelCriteria', $script);
    }

    public function testBuild()
    {
        $schema = <<<EOF
<database name="test_quick_build_2">
    <table name="quick_build_foo_2">
        <column name="id" primaryKey="true" type="INTEGER" autoIncrement="true" />
        <column name="bar" type="INTEGER" />
    </table>
</database>
EOF;
        $builder = new PropelQuickBuilder();
        $builder->setSchema($schema);
        $builder->build();
        $this->assertEquals(0, QuickBuildFoo2Query::create()->count());
        $foo = new QuickBuildFoo2();
        $foo->setBar(3);
        $foo->save();
        $this->assertEquals(1, QuickBuildFoo2Query::create()->count());
        $this->assertEquals($foo, QuickBuildFoo2Query::create()->findOne());
    }

}
