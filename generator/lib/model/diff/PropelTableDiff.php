<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     MIT License
 */



/**
 * Value object for storing Table object diffs
 * Heavily inspired by Doctrine2's Migrations
 * (see http://github.com/doctrine/dbal/tree/master/lib/Doctrine/DBAL/Schema/)
 *
 * @package    propel.generator.model.diff
 */
class PropelTableDiff implements \Stringable
{
    protected $fromTable;
    protected $toTable;

    protected $addedColumns = [];
    protected $removedColumns = [];
    protected $modifiedColumns = [];
    protected $renamedColumns = [];

    protected $addedPkColumns = [];
    protected $removedPkColumns = [];
    protected $renamedPkColumns = [];

    protected $addedIndices = [];
    protected $removedIndices = [];
    protected $modifiedIndices = [];

    protected $addedFks = [];
    protected $removedFks = [];
    protected $modifiedFks = [];

    /**
     * Setter for the fromTable property
     */
    public function setFromTable(Table $fromTable)
    {
        $this->fromTable = $fromTable;
    }

    /**
     * Getter for the fromTable property
     *
     * @return Table
     */
    public function getFromTable()
    {
        return $this->fromTable;
    }

    /**
     * Setter for the toTable property
     */
    public function setToTable(Table $toTable)
    {
        $this->toTable = $toTable;
    }

    /**
     * Getter for the toTable property
     *
     * @return Table
     */
    public function getToTable()
    {
        return $this->toTable;
    }

    /**
     * Setter for the addedColumns property
     *
     * @param array $addedColumns
     */
    public function setAddedColumns($addedColumns)
    {
        $this->addedColumns = $addedColumns;
    }

    /**
     * Add an added column
     *
     * @param string $columnName
     */
    public function addAddedColumn($columnName, Column $addedColumn)
    {
        $this->addedColumns[$columnName] = $addedColumn;
    }

    /**
     * Remove an added column
     *
     * @param string $columnName
     */
    public function removeAddedColumn($columnName)
    {
        unset($this->addedColumns[$columnName]);
    }

    /**
     * Getter for the addedColumns property
     *
     * @return array
     */
    public function getAddedColumns()
    {
        return $this->addedColumns;
    }

    /**
     * Get an added column
     *
     * @param string $columnName
     *
     * @param Column
     */
    public function getAddedColumn($columnName)
    {
        return $this->addedColumns[$columnName];
    }

    /**
     * Setter for the removedColumns property
     *
     * @param array $removedColumns
     */
    public function setRemovedColumns($removedColumns)
    {
        $this->removedColumns = $removedColumns;
    }

    /**
     * Add a removed column
     *
     * @param string $columnName
     */
    public function addRemovedColumn($columnName, Column $removedColumn)
    {
        $this->removedColumns[$columnName] = $removedColumn;
    }

    /**
     * Remove a removed column
     *
     * @param string $columnName
     */
    public function removeRemovedColumn($columnName)
    {
        unset($this->removedColumns[$columnName]);
    }

    /**
     * Getter for the removedColumns property
     *
     * @return array
     */
    public function getRemovedColumns()
    {
        return $this->removedColumns;
    }

    /**
     * Get a removed column
     *
     * @param string $columnName
     *
     * @param Column
     */
    public function getRemovedColumn($columnName)
    {
        return $this->removedColumns[$columnName];
    }

    /**
     * Setter for the modifiedColumns property
     *
     * @param array $modifiedColumns
     */
    public function setModifiedColumns($modifiedColumns)
    {
        $this->modifiedColumns = $modifiedColumns;
    }

    /**
     * Add a column difference
     *
     * @param string           $columnName
     */
    public function addModifiedColumn($columnName, PropelColumnDiff $modifiedColumn)
    {
        $this->modifiedColumns[$columnName] = $modifiedColumn;
    }

    /**
     * Getter for the modifiedColumns property
     *
     * @return array
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns;
    }

    /**
     * Setter for the renamedColumns property
     *
     * @param array $renamedColumns
     */
    public function setRenamedColumns($renamedColumns)
    {
        $this->renamedColumns = $renamedColumns;
    }

    /**
     * Add a renamed column
     *
     * @param Column $fromColumn
     * @param Column $toColumn
     */
    public function addRenamedColumn($fromColumn, $toColumn)
    {
        $this->renamedColumns[] = [$fromColumn, $toColumn];
    }

    /**
     * Getter for the renamedColumns property
     *
     * @return array
     */
    public function getRenamedColumns()
    {
        return $this->renamedColumns;
    }

    /**
     * Setter for the addedPkColumns property
     *
     * @param  $addedPkColumns
     */
    public function setAddedPkColumns($addedPkColumns)
    {
        $this->addedPkColumns = $addedPkColumns;
    }

    /**
     * Add an added Pk column
     *
     * @param string $columnName
     */
    public function addAddedPkColumn($columnName, Column $addedPkColumn)
    {
        $this->addedPkColumns[$columnName] = $addedPkColumn;
    }

    /**
     * Remove an added Pk column
     *
     * @param string $columnName
     */
    public function removeAddedPkColumn($columnName)
    {
        unset($this->addedPkColumns[$columnName]);
    }

    /**
     * Getter for the addedPkColumns property
     *
     * @return array
     */
    public function getAddedPkColumns()
    {
        return $this->addedPkColumns;
    }

    /**
     * Setter for the removedPkColumns property
     *
     * @param  $removedPkColumns
     */
    public function setRemovedPkColumns($removedPkColumns)
    {
        $this->removedPkColumns = $removedPkColumns;
    }

    /**
     * Add a removed Pk column
     *
     * @param string $columnName
     * @param Column $removedColumn
     */
    public function addRemovedPkColumn($columnName, Column $removedPkColumn)
    {
        $this->removedPkColumns[$columnName] = $removedPkColumn;
    }

    /**
     * Remove a removed Pk column
     *
     * @param string $columnName
     */
    public function removeRemovedPkColumn($columnName)
    {
        unset($this->removedPkColumns[$columnName]);
    }

    /**
     * Getter for the removedPkColumns property
     *
     * @return array
     */
    public function getRemovedPkColumns()
    {
        return $this->removedPkColumns;
    }

    /**
     * Setter for the renamedPkColumns property
     *
     * @param $renamedPkColumns
     */
    public function setRenamedPkColumns($renamedPkColumns)
    {
        $this->renamedPkColumns = $renamedPkColumns;
    }

    /**
     * Add a renamed Pk column
     *
     * @param Column $fromColumn
     * @param Column $toColumn
     */
    public function addRenamedPkColumn($fromColumn, $toColumn)
    {
        $this->renamedPkColumns[] = [$fromColumn, $toColumn];
    }

    /**
     * Getter for the renamedPkColumns property
     *
     * @return array
     */
    public function getRenamedPkColumns()
    {
        return $this->renamedPkColumns;
    }

    /**
     * Whether the primary key was modified
     *
     * @return boolean
     */
    public function hasModifiedPk()
    {
        return $this->renamedPkColumns || $this->removedPkColumns || $this->addedPkColumns;
    }

    /**
     * Setter for the addedIndices property
     *
     * @param  $addedIndices
     */
    public function setAddedIndices($addedIndices)
    {
        $this->addedIndices = $addedIndices;
    }

    /**
     * Add an added Index
     *
     * @param string $indexName
     */
    public function addAddedIndex($indexName, Index $addedIndex)
    {
        $this->addedIndices[$indexName] = $addedIndex;
    }

    /**
     * Getter for the addedIndices property
     *
     * @return array
     */
    public function getAddedIndices()
    {
        return $this->addedIndices;
    }

    /**
     * Setter for the removedIndices property
     *
     * @param  $removedIndices
     */
    public function setRemovedIndices($removedIndices)
    {
        $this->removedIndices = $removedIndices;
    }

    /**
     * Add a removed Index
     *
     * @param string $indexName
     */
    public function addRemovedIndex($indexName, Index $removedIndex)
    {
        $this->removedIndices[$indexName] = $removedIndex;
    }

    /**
     * Getter for the removedIndices property
     *
     * @return array
     */
    public function getRemovedIndices()
    {
        return $this->removedIndices;
    }

    /**
     * Setter for the modifiedIndices property
     *
     * @param  $modifiedIndices
     */
    public function setModifiedIndices($modifiedIndices)
    {
        $this->modifiedIndices = $modifiedIndices;
    }

    /**
     * Add a modified Index
     *
     * @param string $indexName
     */
    public function addModifiedIndex($indexName, Index $fromIndex, Index $toIndex)
    {
        $this->modifiedIndices[$indexName] = [$fromIndex, $toIndex];
    }

    /**
     * Getter for the modifiedIndices property
     *
     * @return
     */
    public function getModifiedIndices()
    {
        return $this->modifiedIndices;
    }

    /**
     * Setter for the addedFks property
     *
     * @param  $addedFks
     */
    public function setAddedFks($addedFks)
    {
        $this->addedFks = $addedFks;
    }

    /**
     * Add an added Fk column
     *
     * @param string     $fkName
     */
    public function addAddedFk($fkName, ForeignKey $addedFk)
    {
        $this->addedFks[$fkName] = $addedFk;
    }

    /**
     * Remove an added Fk column
     *
     * @param string $fkName
     */
    public function removeAddedFk($fkName)
    {
        unset($this->addedFks[$fkName]);
    }

    /**
     * Getter for the addedFks property
     *
     * @return array
     */
    public function getAddedFks()
    {
        return $this->addedFks;
    }

    /**
     * Setter for the removedFks property
     *
     * @param  $removedFks
     */
    public function setRemovedFks($removedFks)
    {
        $this->removedFks = $removedFks;
    }

    /**
     * Add a removed Fk column
     *
     * @param string     $fkName
     * @param ForeignKey $removedColumn
     */
    public function addRemovedFk($fkName, ForeignKey $removedFk)
    {
        $this->removedFks[$fkName] = $removedFk;
    }

    /**
     * Remove a removed Fk column
     *
     * @param string $fkName
     */
    public function removeRemovedFk($fkName)
    {
        unset($this->removedFks[$fkName]);
    }

    /**
     * Getter for the removedFks property
     *
     * @return array
     */
    public function getRemovedFks()
    {
        return $this->removedFks;
    }

    /**
     * Setter for the modifiedFks property
     *
     * @param array $modifiedFks
     */
    public function setModifiedFks($modifiedFks)
    {
        $this->modifiedFks = $modifiedFks;
    }

    /**
     * Add a modified Fk
     *
     * @param string     $fkName
     */
    public function addModifiedFk($fkName, ForeignKey $fromFk, ForeignKey $toFk)
    {
        $this->modifiedFks[$fkName] = [$fromFk, $toFk];
    }

    /**
     * Getter for the modifiedFks property
     *
     * @return array
     */
    public function getModifiedFks()
    {
        return $this->modifiedFks;
    }

    /**
     * Get the reverse diff for this diff
     *
     * @return PropelTableDiff
     */
    public function getReverseDiff()
    {
        $diff = new self();

        // tables
        $diff->setFromTable($this->getToTable());
        $diff->setToTable($this->getFromTable());

        // columns
        $diff->setAddedColumns($this->getRemovedColumns());
        $diff->setRemovedColumns($this->getAddedColumns());
        $renamedColumns = [];
        foreach ($this->getRenamedColumns() as $columnRenaming) {
            $renamedColumns[] = array_reverse($columnRenaming);
        }
        $diff->setRenamedColumns($renamedColumns);
        $columnDiffs = [];
        foreach ($this->getModifiedColumns() as $name => $columnDiff) {
            $columnDiffs[$name] = $columnDiff->getReverseDiff();
        }
        $diff->setModifiedColumns($columnDiffs);

        // pks
        $diff->setAddedPkColumns($this->getRemovedPkColumns());
        $diff->setRemovedPkColumns($this->getAddedPkColumns());
        $renamedPkColumns = [];
        foreach ($this->getRenamedPkColumns() as $columnRenaming) {
            $renamedPkColumns[] = array_reverse($columnRenaming);
        }
        $diff->setRenamedPkColumns($renamedPkColumns);

        // indices
        $diff->setAddedIndices($this->getRemovedIndices());
        $diff->setRemovedIndices($this->getAddedIndices());
        $indexDiffs = [];
        foreach ($this->getModifiedIndices() as $name => $indexDiff) {
            $indexDiffs[$name] = array_reverse($indexDiff);
        }
        $diff->setModifiedIndices($indexDiffs);

        // fks
        $diff->setAddedFks($this->getRemovedFks());
        $diff->setRemovedFks($this->getAddedFks());
        $fkDiffs = [];
        foreach ($this->getModifiedFks() as $name => $fkDiff) {
            $fkDiffs[$name] = array_reverse($fkDiff);
        }
        $diff->setModifiedFks($fkDiffs);

        return $diff;
    }

    public function __toString(): string
    {
        $ret = '';
        $ret .= sprintf("  %s:\n", $this->getFromTable()->getName());
        if ($addedColumns = $this->getAddedColumns()) {
            $ret .= "    addedColumns:\n";
            foreach ($addedColumns as $colname => $column) {
                $ret .= sprintf("      - %s\n", $colname);
            }
        }
        if ($removedColumns = $this->getRemovedColumns()) {
            $ret .= "    removedColumns:\n";
            foreach ($removedColumns as $colname => $column) {
                $ret .= sprintf("      - %s\n", $colname);
            }
        }
        if ($modifiedColumns = $this->getModifiedColumns()) {
            $ret .= "    modifiedColumns:\n";
            foreach ($modifiedColumns as $colname => $colDiff) {
                $ret .= $colDiff->__toString();
            }
        }
        if ($renamedColumns = $this->getRenamedColumns()) {
            $ret .= "    renamedColumns:\n";
            foreach ($renamedColumns as $columnRenaming) {
                [$fromColumn, $toColumn] = $columnRenaming;
                $ret .= sprintf("      %s: %s\n", $fromColumn->getName(), $toColumn->getName());
            }
        }
        if ($addedIndices = $this->getAddedIndices()) {
            $ret .= "    addedIndices:\n";
            foreach ($addedIndices as $indexName => $index) {
                $ret .= sprintf("      - %s\n", $indexName);
            }
        }
        if ($removedIndices = $this->getRemovedIndices()) {
            $ret .= "    removedIndices:\n";
            foreach ($removedIndices as $indexName => $index) {
                $ret .= sprintf("      - %s\n", $indexName);
            }
        }
        if ($modifiedIndices = $this->getModifiedIndices()) {
            $ret .= "    modifiedIndices:\n";
            foreach ($modifiedIndices as $indexName => $indexDiff) {
                $ret .= sprintf("      - %s\n", $indexName);
            }
        }
        if ($addedFks = $this->getAddedFks()) {
            $ret .= "    addedFks:\n";
            foreach ($addedFks as $fkName => $fk) {
                $ret .= sprintf("      - %s\n", $fkName);
            }
        }
        if ($removedFks = $this->getRemovedFks()) {
            $ret .= "    removedFks:\n";
            foreach ($removedFks as $fkName => $fk) {
                $ret .= sprintf("      - %s\n", $fkName);
            }
        }
        if ($modifiedFks = $this->getModifiedFks()) {
            $ret .= "    modifiedFks:\n";
            foreach ($modifiedFks as $fkName => $fkFromTo) {
                $ret .= sprintf("      %s:\n", $fkName);
                [$fromFk, $toFk] = $fkFromTo;
                $fromLocalColumns = json_encode($fromFk->getLocalColumns(), JSON_THROW_ON_ERROR);
                $toLocalColumns = json_encode($toFk->getLocalColumns(), JSON_THROW_ON_ERROR);
                if ($fromLocalColumns != $toLocalColumns) {
                    $ret .= sprintf("          localColumns: from %s to %s\n", $fromLocalColumns, $toLocalColumns);
                }
                $fromForeignColumns = json_encode($fromFk->getForeignColumns(), JSON_THROW_ON_ERROR);
                $toForeignColumns = json_encode($toFk->getForeignColumns(), JSON_THROW_ON_ERROR);
                if ($fromForeignColumns != $toForeignColumns) {
                    $ret .= sprintf("          foreignColumns: from %s to %s\n", $fromForeignColumns, $toForeignColumns);
                }
                if ($fromFk->normalizeFKey($fromFk->getOnUpdate()) != $toFk->normalizeFKey($toFk->getOnUpdate())) {
                    $ret .= sprintf("          onUpdate: from %s to %s\n", $fromFk->getOnUpdate(), $toFk->getOnUpdate());
                }
                if ($fromFk->normalizeFKey($fromFk->getOnDelete()) != $toFk->normalizeFKey($toFk->getOnDelete())) {
                    $ret .= sprintf("          onDelete: from %s to %s\n", $fromFk->getOnDelete(), $toFk->getOnDelete());
                }
            }
        }

        return $ret;
    }
}
