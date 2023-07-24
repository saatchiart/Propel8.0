<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

class TestAllHooksBehavior extends Behavior
{
  protected $tableModifier, $objectBuilderModifier, $peerBuilderModifier, $queryBuilderModifier;

  public function getTableModifier()
  {
    if (is_null($this->tableModifier)) {
      $this->tableModifier = new TestAllHooksTableModifier($this);
    }

    return $this->tableModifier;
  }

  public function getObjectBuilderModifier()
  {
    if (is_null($this->objectBuilderModifier)) {
      $this->objectBuilderModifier = new TestAllHooksObjectBuilderModifier($this);
    }

    return $this->objectBuilderModifier;
  }

  public function getPeerBuilderModifier()
  {
    if (is_null($this->peerBuilderModifier)) {
      $this->peerBuilderModifier = new TestAllHooksPeerBuilderModifier($this);
    }

    return $this->peerBuilderModifier;
  }

  public function getQueryBuilderModifier()
  {
    if (is_null($this->queryBuilderModifier)) {
      $this->queryBuilderModifier = new TestAllHooksQueryBuilderModifier($this);
    }

    return $this->queryBuilderModifier;
  }
}

class TestAllHooksTableModifier
{
  protected $behavior, $table;

  public function __construct($behavior)
  {
    $this->behavior = $behavior;
    $this->table = $behavior->getTable();
  }

  public function modifyTable()
  {
    $this->table->addColumn(['name' => 'test', 'type' => 'TIMESTAMP']);
  }
}

class TestAllHooksObjectBuilderModifier
{
  public function objectAttributes($builder)
  {
    return 'public $customAttribute = 1;';
  }

  public function preSave($builder)
  {
    return '$this->preSave = 1;$this->preSaveIsAfterSave = isset($affectedRows);$this->preSaveBuilder="' . $builder::class . '";';
  }

  public function postSave($builder)
  {
    return '$this->postSave = 1;$this->postSaveIsAfterSave = isset($affectedRows);$this->postSaveBuilder="' . $builder::class . '";';
  }

  public function preInsert($builder)
  {
    return '$this->preInsert = 1;$this->preInsertIsAfterSave = isset($affectedRows);$this->preInsertBuilder="' . $builder::class . '";';
  }

  public function postInsert($builder)
  {
    return '$this->postInsert = 1;$this->postInsertIsAfterSave = isset($affectedRows);$this->postInsertBuilder="' . $builder::class . '";';
  }

  public function preUpdate($builder)
  {
    return '$this->preUpdate = 1;$this->preUpdateIsAfterSave = isset($affectedRows);$this->preUpdateBuilder="' . $builder::class . '";';
  }

  public function postUpdate($builder)
  {
    return '$this->postUpdate = 1;$this->postUpdateIsAfterSave = isset($affectedRows);$this->postUpdateBuilder="' . $builder::class . '";';
  }

  public function preDelete($builder)
  {
    return '$this->preDelete = 1;$this->preDeleteIsBeforeDelete = isset(Table3Peer::$instances[$this->id]);$this->preDeleteBuilder="' . $builder::class . '";';
  }

  public function postDelete($builder)
  {
    return '$this->postDelete = 1;$this->postDeleteIsBeforeDelete = isset(Table3Peer::$instances[$this->id]);$this->postDeleteBuilder="' . $builder::class . '";';
  }

  public function postHydrate($builder)
  {
    return '$this->postHydrate = 1;$this->postHydrateIsAfterHydrate = isset($this->id);$this->postHydrateBuilder="' . $builder::class . '";';
  }

  public function objectMethods($builder)
  {
    return 'public function hello() { return "' . $builder::class .'"; }';
  }

  public function objectCall($builder)
  {
      return 'if ($name == "foo") return "bar";';
  }

  public function objectFilter(&$string, $builder)
  {
    $string .= 'class testObjectFilter { const FOO = "' . $builder::class . '"; }';
  }
}

class TestAllHooksPeerBuilderModifier
{
  public function staticAttributes($builder)
  {
    return 'public static $customStaticAttribute = 1;public static $staticAttributeBuilder = "' . $builder::class . '";';
  }

  public function staticMethods($builder)
  {
    return 'public static function hello() { return "' . $builder::class . '"; }';
  }

  public function preSelect($builder)
  {
    return '$con->preSelect = "' . $builder::class . '";';
  }

  public function peerFilter(&$string, $builder)
  {
    $string .= 'class testPeerFilter { const FOO = "' . $builder::class . '"; }';
  }
}

class TestAllHooksQueryBuilderModifier
{
    public function preSelectQuery($builder)
    {
        return '// foo';
    }

    public function preDeleteQuery($builder)
    {
        return '// foo';
    }

    public function postDeleteQuery($builder)
    {
        return '// foo';
    }

    public function preUpdateQuery($builder)
    {
        return '// foo';
    }

    public function postUpdateQuery($builder)
    {
        return '// foo';
    }
}
