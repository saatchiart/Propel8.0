<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

/**
 * A validator for validating the (PHP) type of the value submitted.
 *
 * <code>
 *   <column name="some_int" type="INTEGER" required="true"/>
 *
 *   <validator column="some_int">
 *     <rule name="type" value="integer" message="Please specify an integer value for some_int column." />
 *   </validator>
 * </code>
 *
 * @author     Hans Lellelid <hans@xmpl.org>
 * @version    $Revision$
 * @package    propel.runtime.validator
 */
class TypeValidator implements BasicValidator
{
    /**
     * @see       BasicValidator::isValid()
     *
     * @param ValidatorMap $map
     * @param mixed        $value
     *
     * @return boolean
     *
     * @throws PropelException
     */
    public function isValid(ValidatorMap $map, $value)
    {
        return match ($map->getValue()) {
            'array' => is_array($value),
            'bool', 'boolean' => is_bool($value),
            'float' => is_float($value),
            'int', 'integer' => is_int($value),
            'numeric' => is_numeric($value),
            'object' => is_object($value),
            'resource' => is_resource($value),
            'scalar' => is_scalar($value),
            'string' => is_string($value),
            'function' => function_exists($value),
            default => throw new PropelException('Unknown type ' . $map->getValue()),
        };
    }
}
