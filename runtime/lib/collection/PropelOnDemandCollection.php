<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

/**
 * Class for iterating over a statement and returning one Propel object at a time
 *
 * @author     Francois Zaninotto
 * @package    propel.runtime.collection
 */
class PropelOnDemandCollection extends PropelCollection
{
    /**
     * @var       PropelOnDemandIterator
     */
    protected $iterator;

    public function initIterator(PropelFormatter $formatter, PDOStatement $stmt)
    {
        $this->iterator = new PropelOnDemandIterator($formatter, $stmt);
    }

    /**
     * Populates the collection from an array
     * Each object is populated from an array and the result is stored
     * Does not empty the collection before adding the data from the array
     *
     * @param array $arr
     *
     * @throws PropelException
     */
    public function fromArray($arr): never
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    // IteratorAggregate Interface

    /**
     * @inheritDoc
     */
    public function getIterator(): PropelOnDemandIterator
    {
        return $this->iterator;
    }

    // ArrayAccess Interface

    /**
     * @inheritDoc
     *
     * @throws PropelException
     *
     * @param integer $offset
     */
    public function offsetExists($offset): bool
    {
        throw new PropelException('The On Demand Collection does not allow access by offset');
    }

    /**
     * @inheritDoc
     *
     * @throws PropelException
     *
     * @param integer $offset
     */
    public function offsetGet($offset): mixed
    {
        throw new PropelException('The On Demand Collection does not allow access by offset');
    }

    /**
     * @inheritDoc
     *
     * @throws PropelException
     *
     * @param integer $offset
     */
    public function offsetSet($offset, mixed $value): void
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /**
     * @inheritDoc
     *
     * @throws PropelException
     *
     * @param integer $offset
     */
    public function offsetUnset($offset): void
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    // Serializable Interface

    /**
     * @inheritDoc
     *
     * @throws PropelException
     */
    public function serialize(): never
    {
        throw new PropelException('The On Demand Collection cannot be serialized');
    }

    /**
     * @inheritDoc
     *
     * @throws PropelException
     *
     * @param string $data
     *
     * @return void
     */
    public function unserialize($data): never
    {
        throw new PropelException('The On Demand Collection cannot be serialized');
    }

    // Countable Interface

    /**
     * @inheritDoc
     *
     * Returns the number of rows in the resultset
     * Warning: this number is inaccurate for most databases. Do not rely on it for a portable application.
     *
     * @return integer Number of results
     */
    public function count(): int
    {
        return $this->iterator->count();
    }

    // ArrayObject methods

    /** @inheritDoc */
    public function append($value): void
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function prepend($value): never
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function asort(int $flags = SORT_REGULAR): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function exchangeArray($input): array
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function getArrayCopy(): array
    {
        throw new PropelException('The On Demand Collection does not allow access by offset');
    }

    /** @inheritDoc */
    public function getFlags(): int
    {
        throw new PropelException('The On Demand Collection does not allow access by offset');
    }

    /** @inheritDoc */
    public function ksort(int $flags = SORT_REGULAR): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function natcasesort(): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function natsort(): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function setFlags($flags): void
    {
        throw new PropelException('The On Demand Collection does not allow acces by offset');
    }

    /** @inheritDoc */
    public function uasort($cmp_function): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /** @inheritDoc */
    public function uksort($cmp_function): bool
    {
        throw new PropelException('The On Demand Collection is read only');
    }

    /**
     * {@inheritdoc}
     */
    public function exportTo($parser, $usePrefix = true, $includeLazyLoadColumns = true): never
    {
        throw new PropelException('A PropelOnDemandCollection cannot be exported.');
    }
}
