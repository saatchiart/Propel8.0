<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license     MIT License
 */



/**
 * Service class for comparing Column objects.
 * Heavily inspired by Doctrine2's Migrations
 * (see http://github.com/doctrine/dbal/tree/master/lib/Doctrine/DBAL/Schema/)
 *
 * @package    propel.generator.model.diff
 */
class PropelColumnComparator
{
    /**
     * Compute and return the difference between two column objects
     *
     *
     * @return PropelColumnDiff|boolean return false if the two columns are similar
     */
    public static function computeDiff(Column $fromColumn, Column $toColumn)
    {
        if ($changedProperties = self::compareColumns($fromColumn, $toColumn)) {
            if ($fromColumn->hasPlatform() || $toColumn->hasPlatform()) {
                $platform = $fromColumn->hasPlatform() ? $fromColumn->getPlatform() : $toColumn->getPlatform();
                if ($platform->getColumnDDL($fromColumn) == $platform->getColumnDDl($toColumn)) {
                    return false;
                }
            }
            $columnDiff = new PropelColumnDiff();
            $columnDiff->setFromColumn($fromColumn);
            $columnDiff->setToColumn($toColumn);
            $columnDiff->setChangedProperties($changedProperties);

            return $columnDiff;
        } else {
            return false;
        }
    }

    public static function compareColumns(Column $fromColumn, Column $toColumn)
    {
        $changedProperties = [];

        // compare column types
        $fromDomain = $fromColumn->getDomain();
        $toDomain = $toColumn->getDomain();
        if ($fromDomain->getType() != $toDomain->getType()) {
            $changedProperties['type'] = [$fromDomain->getType(), $toDomain->getType()];
        }
        if ($fromDomain->getScale() != $toDomain->getScale()) {
            $changedProperties['scale'] = [$fromDomain->getScale(), $toDomain->getScale()];
        }
        if ($fromDomain->getSize() != $toDomain->getSize()) {
            $changedProperties['size'] = [$fromDomain->getSize(), $toDomain->getSize()];
        }
        if (strtoupper($fromDomain->getSqlType()) != strtoupper($toDomain->getSqlType())) {
            $changedProperties['sqlType'] = [$fromDomain->getSqlType(), $toDomain->getSqlType()];
        }
        if ($fromColumn->isNotNull() != $toColumn->isNotNull()) {
            $changedProperties['notNull'] = [$fromColumn->isNotNull(), $toColumn->isNotNull()];
        }

        // compare column default value
        $fromDefaultValue = $fromColumn->getDefaultValue();
        $toDefaultValue = $toColumn->getDefaultValue();
        if ($fromDefaultValue && !$toDefaultValue) {
            $changedProperties['defaultValueType'] = [$fromDefaultValue->getType(), null];
            $changedProperties['defaultValueValue'] = [$fromDefaultValue->getValue(), null];
        } elseif (!$fromDefaultValue && $toDefaultValue) {
            $changedProperties['defaultValueType'] = [null, $toDefaultValue->getType()];
            $changedProperties['defaultValueValue'] = [null, $toDefaultValue->getValue()];
        } elseif ($fromDefaultValue && $toDefaultValue) {
            if (!$fromDefaultValue->equals($toDefaultValue)) {
                if ($fromDefaultValue->getType() != $toDefaultValue->getType()) {
                    $changedProperties['defaultValueType'] = [$fromDefaultValue->getType(), $toDefaultValue->getType()];
                }
                if ($fromDefaultValue->getValue() != $toDefaultValue->getValue()) {
                    $changedProperties['defaultValueValue'] = [$fromDefaultValue->getValue(), $toDefaultValue->getValue()];
                }
            }
        }

        if ($fromColumn->isAutoIncrement() != $toColumn->isAutoIncrement()) {
            $changedProperties['autoIncrement'] = [$fromColumn->isAutoIncrement(), $toColumn->isAutoIncrement()];
        }

        return $changedProperties;
    }
}
