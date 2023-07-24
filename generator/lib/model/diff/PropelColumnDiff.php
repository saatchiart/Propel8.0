<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     MIT License
 */


/**
 * Value object for storing Column object diffs.
 * Heavily inspired by Doctrine2's Migrations
 * (see http://github.com/doctrine/dbal/tree/master/lib/Doctrine/DBAL/Schema/)
 *
 * @package    propel.generator.model.diff
 */
class PropelColumnDiff implements \Stringable
{
    protected $changedProperties = [];
    protected $fromColumn;
    protected $toColumn;

    /**
     * Setter for the changedProperties property
     *
     * @param array $changedProperties
     */
    public function setChangedProperties($changedProperties)
    {
        $this->changedProperties = $changedProperties;
    }

    /**
     * Getter for the changedProperties property
     *
     * @return array
     */
    public function getChangedProperties()
    {
        return $this->changedProperties;
    }

    /**
     * Setter for the fromColumn property
     */
    public function setFromColumn(Column $fromColumn)
    {
        $this->fromColumn = $fromColumn;
    }

    /**
     * Getter for the fromColumn property
     *
     * @return Column
     */
    public function getFromColumn()
    {
        return $this->fromColumn;
    }

    /**
     * Setter for the toColumn property
     */
    public function setToColumn(Column $toColumn)
    {
        $this->toColumn = $toColumn;
    }

    /**
     * Getter for the toColumn property
     *
     * @return Column
     */
    public function getToColumn()
    {
        return $this->toColumn;
    }

    /**
     * Get the reverse diff for this diff
     *
     * @return PropelColumnDiff
     */
    public function getReverseDiff()
    {
        $diff = new self();

        // columns
        $diff->setFromColumn($this->getToColumn());
        $diff->setToColumn($this->getFromColumn());

        // properties
        $changedProperties = [];
        foreach ($this->getChangedProperties() as $name => $propertyChange) {
            $changedProperties[$name] = array_reverse($propertyChange);
        }
        $diff->setChangedProperties($changedProperties);

        return $diff;
    }

    public function __toString(): string
    {
        $ret = '';
        $ret .= sprintf("      %s:\n", $this->getFromColumn()->getFullyQualifiedName());
        $ret .= "        modifiedProperties:\n";
        foreach ($this->getChangedProperties() as $key => $value) {
            $ret .= sprintf("          %s: %s\n", $key, json_encode($value, JSON_THROW_ON_ERROR));
        }

        return $ret;
    }
}
