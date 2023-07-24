<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

/**
 * A class that maps PropelTypes to PHP native types, PDO types (and Creole types).
 *
 * @author     Hans Lellelid <hans@xmpl.org> (Propel)
 * @version    $Revision$
 * @package    propel.generator.model
 */
class PropelTypes
{

    final public const CHAR = "CHAR";
    final public const VARCHAR = "VARCHAR";
    final public const LONGVARCHAR = "LONGVARCHAR";
    final public const CLOB = "CLOB";
    final public const CLOB_EMU = "CLOB_EMU";
    final public const NUMERIC = "NUMERIC";
    final public const DECIMAL = "DECIMAL";
    final public const TINYINT = "TINYINT";
    final public const SMALLINT = "SMALLINT";
    final public const INTEGER = "INTEGER";
    final public const BIGINT = "BIGINT";
    final public const REAL = "REAL";
    final public const FLOAT = "FLOAT";
    final public const DOUBLE = "DOUBLE";
    final public const BINARY = "BINARY";
    final public const VARBINARY = "VARBINARY";
    final public const LONGVARBINARY = "LONGVARBINARY";
    final public const BLOB = "BLOB";
    final public const DATE = "DATE";
    final public const TIME = "TIME";
    final public const TIMESTAMP = "TIMESTAMP";
    final public const BU_DATE = "BU_DATE";
    final public const BU_TIMESTAMP = "BU_TIMESTAMP";
    final public const BOOLEAN = "BOOLEAN";
    final public const BOOLEAN_EMU = "BOOLEAN_EMU";
    final public const OBJECT = "OBJECT";
    final public const PHP_ARRAY = "ARRAY";
    final public const ENUM = "ENUM";

    private static array $TEXT_TYPES = [self::CHAR, self::VARCHAR, self::LONGVARCHAR, self::CLOB, self::DATE, self::TIME, self::TIMESTAMP, self::BU_DATE, self::BU_TIMESTAMP];

    private static array $LOB_TYPES = [self::VARBINARY, self::LONGVARBINARY, self::BLOB];

    private static array $TEMPORAL_TYPES = [self::DATE, self::TIME, self::TIMESTAMP, self::BU_DATE, self::BU_TIMESTAMP];

    private static array $NUMERIC_TYPES = [self::SMALLINT, self::TINYINT, self::INTEGER, self::BIGINT, self::FLOAT, self::DOUBLE, self::NUMERIC, self::DECIMAL, self::REAL];

    private static array $BOOLEAN_TYPES = [self::BOOLEAN, self::BOOLEAN_EMU];

    final public const CHAR_NATIVE_TYPE = "string";
    final public const VARCHAR_NATIVE_TYPE = "string";
    final public const LONGVARCHAR_NATIVE_TYPE = "string";
    final public const CLOB_NATIVE_TYPE = "string";
    final public const CLOB_EMU_NATIVE_TYPE = "resource";
    final public const NUMERIC_NATIVE_TYPE = "string";
    final public const DECIMAL_NATIVE_TYPE = "string";
    final public const TINYINT_NATIVE_TYPE = "int";
    final public const SMALLINT_NATIVE_TYPE = "int";
    final public const INTEGER_NATIVE_TYPE = "int";
    final public const BIGINT_NATIVE_TYPE = "string";
    final public const REAL_NATIVE_TYPE = "double";
    final public const FLOAT_NATIVE_TYPE = "double";
    final public const DOUBLE_NATIVE_TYPE = "double";
    final public const BINARY_NATIVE_TYPE = "string";
    final public const VARBINARY_NATIVE_TYPE = "string";
    final public const LONGVARBINARY_NATIVE_TYPE = "string";
    final public const BLOB_NATIVE_TYPE = "resource";
    final public const BU_DATE_NATIVE_TYPE = "string";
    final public const DATE_NATIVE_TYPE = "string";
    final public const TIME_NATIVE_TYPE = "string";
    final public const TIMESTAMP_NATIVE_TYPE = "string";
    final public const BU_TIMESTAMP_NATIVE_TYPE = "string";
    final public const BOOLEAN_NATIVE_TYPE = "boolean";
    final public const BOOLEAN_EMU_NATIVE_TYPE = "boolean";
    final public const OBJECT_NATIVE_TYPE = "";
    final public const PHP_ARRAY_NATIVE_TYPE = "array";
    final public const ENUM_NATIVE_TYPE = "int";

    /**
     * Mapping between Propel types and PHP native types.
     */
    private static array $propelToPHPNativeMap = [self::CHAR => self::CHAR_NATIVE_TYPE, self::VARCHAR => self::VARCHAR_NATIVE_TYPE, self::LONGVARCHAR => self::LONGVARCHAR_NATIVE_TYPE, self::CLOB => self::CLOB_NATIVE_TYPE, self::CLOB_EMU => self::CLOB_EMU_NATIVE_TYPE, self::NUMERIC => self::NUMERIC_NATIVE_TYPE, self::DECIMAL => self::DECIMAL_NATIVE_TYPE, self::TINYINT => self::TINYINT_NATIVE_TYPE, self::SMALLINT => self::SMALLINT_NATIVE_TYPE, self::INTEGER => self::INTEGER_NATIVE_TYPE, self::BIGINT => self::BIGINT_NATIVE_TYPE, self::REAL => self::REAL_NATIVE_TYPE, self::FLOAT => self::FLOAT_NATIVE_TYPE, self::DOUBLE => self::DOUBLE_NATIVE_TYPE, self::BINARY => self::BINARY_NATIVE_TYPE, self::VARBINARY => self::VARBINARY_NATIVE_TYPE, self::LONGVARBINARY => self::LONGVARBINARY_NATIVE_TYPE, self::BLOB => self::BLOB_NATIVE_TYPE, self::DATE => self::DATE_NATIVE_TYPE, self::BU_DATE => self::BU_DATE_NATIVE_TYPE, self::TIME => self::TIME_NATIVE_TYPE, self::TIMESTAMP => self::TIMESTAMP_NATIVE_TYPE, self::BU_TIMESTAMP => self::BU_TIMESTAMP_NATIVE_TYPE, self::BOOLEAN => self::BOOLEAN_NATIVE_TYPE, self::BOOLEAN_EMU => self::BOOLEAN_EMU_NATIVE_TYPE, self::OBJECT => self::OBJECT_NATIVE_TYPE, self::PHP_ARRAY => self::PHP_ARRAY_NATIVE_TYPE, self::ENUM => self::ENUM_NATIVE_TYPE];

    /**
     * Mapping between Propel types and Creole types (for rev-eng task)
     */
    private static array $propelTypeToCreoleTypeMap = [
        self::CHAR => self::CHAR,
        self::VARCHAR => self::VARCHAR,
        self::LONGVARCHAR => self::LONGVARCHAR,
        self::CLOB => self::CLOB,
        self::NUMERIC => self::NUMERIC,
        self::DECIMAL => self::DECIMAL,
        self::TINYINT => self::TINYINT,
        self::SMALLINT => self::SMALLINT,
        self::INTEGER => self::INTEGER,
        self::BIGINT => self::BIGINT,
        self::REAL => self::REAL,
        self::FLOAT => self::FLOAT,
        self::DOUBLE => self::DOUBLE,
        self::BINARY => self::BINARY,
        self::VARBINARY => self::VARBINARY,
        self::LONGVARBINARY => self::LONGVARBINARY,
        self::BLOB => self::BLOB,
        self::DATE => self::DATE,
        self::TIME => self::TIME,
        self::TIMESTAMP => self::TIMESTAMP,
        self::BOOLEAN => self::BOOLEAN,
        self::BOOLEAN_EMU => self::BOOLEAN_EMU,
        self::OBJECT => self::OBJECT,
        self::PHP_ARRAY => self::PHP_ARRAY,
        self::ENUM => self::ENUM,
        // These are pre-epoch dates, which we need to map to String type
        // since they cannot be properly handled using strtotime() -- or even numeric
        // timestamps on Windows.
        self::BU_DATE => self::VARCHAR,
        self::BU_TIMESTAMP => self::VARCHAR,
    ];

    /**
     * Mapping between Propel types and PDO type constants (for prepared statement setting).
     */
    private static array $propelTypeToPDOTypeMap = [
        self::CHAR => PDO::PARAM_STR,
        self::VARCHAR => PDO::PARAM_STR,
        self::LONGVARCHAR => PDO::PARAM_STR,
        self::CLOB => PDO::PARAM_STR,
        self::CLOB_EMU => PDO::PARAM_STR,
        self::NUMERIC => PDO::PARAM_INT,
        self::DECIMAL => PDO::PARAM_STR,
        self::TINYINT => PDO::PARAM_INT,
        self::SMALLINT => PDO::PARAM_INT,
        self::INTEGER => PDO::PARAM_INT,
        self::BIGINT => PDO::PARAM_STR,
        self::REAL => PDO::PARAM_STR,
        self::FLOAT => PDO::PARAM_STR,
        self::DOUBLE => PDO::PARAM_STR,
        self::BINARY => PDO::PARAM_STR,
        self::VARBINARY => PDO::PARAM_LOB,
        self::LONGVARBINARY => PDO::PARAM_LOB,
        self::BLOB => PDO::PARAM_LOB,
        self::DATE => PDO::PARAM_STR,
        self::TIME => PDO::PARAM_STR,
        self::TIMESTAMP => PDO::PARAM_STR,
        self::BOOLEAN => PDO::PARAM_BOOL,
        self::BOOLEAN_EMU => PDO::PARAM_INT,
        self::OBJECT => PDO::PARAM_STR,
        self::PHP_ARRAY => PDO::PARAM_STR,
        self::ENUM => PDO::PARAM_INT,
        // These are pre-epoch dates, which we need to map to String type
        // since they cannot be properly handled using strtotime() -- or even numeric
        // timestamps on Windows.
        self::BU_DATE => PDO::PARAM_STR,
        self::BU_TIMESTAMP => PDO::PARAM_STR,
    ];

    private static array $pdoTypeNames = [PDO::PARAM_BOOL => 'PDO::PARAM_BOOL', PDO::PARAM_NULL => 'PDO::PARAM_NULL', PDO::PARAM_INT  => 'PDO::PARAM_INT', PDO::PARAM_STR  => 'PDO::PARAM_STR', PDO::PARAM_LOB  => 'PDO::PARAM_LOB'];

    /**
     * Return native PHP type which corresponds to the
     * Creole type provided. Use in the base object class generation.
     *
     * @param  string $propelType The Propel type name.
     * @return string Name of the native PHP type
     */
    public static function getPhpNative($propelType)
    {
        return self::$propelToPHPNativeMap[$propelType];
    }

    /**
     * Returns the correct Creole type _name_ for propel added types
     *
     * @param string $type the propel added type.
     *
     * @return string Name of the the correct Creole type (e.g. "VARCHAR").
     */
    public static function getCreoleType($type)
    {
        return self::$propelTypeToCreoleTypeMap[$type];
    }

    /**
     * Returns the PDO type (PDO::PARAM_* constant) value.
     *
     * @return int
     */
    public static function getPDOType($type)
    {
        return self::$propelTypeToPDOTypeMap[$type];
    }

    /**
     * Returns the PDO type ('PDO::PARAM_*' constant) name.
     *
     * @return string
     */
    public static function getPdoTypeString($type)
    {
        return self::$pdoTypeNames[self::$propelTypeToPDOTypeMap[$type]];
    }

    /**
     * Returns Propel type constant corresponding to Creole type code.
     * Used but Propel Creole task.
     *
     * @param int $sqlType The Creole SQL type constant.
     *
     * @return string The Propel type to use or NULL if none found.
     */
    public static function getPropelType($sqlType)
    {
        if (isset(self::$creoleToPropelTypeMap[$sqlType])) {
            return self::$creoleToPropelTypeMap[$sqlType];
        }
    }

    /**
     * Get array of Propel types.
     *
     * @return string[]
     */
    public static function getPropelTypes()
    {
        return array_keys(self::$propelTypeToCreoleTypeMap);
    }

    /**
     * Whether passed type is a temporal (date/time/timestamp) type.
     *
     * @param string $type Propel type
     *
     * @return boolean
     */
    public static function isTemporalType($type)
    {
        return in_array($type, self::$TEMPORAL_TYPES);
    }

    /**
     * Returns true if values for the type need to be quoted.
     *
     * @param string $type The Propel type to check.
     *
     * @return boolean True if values for the type need to be quoted.
     */
    public static function isTextType($type)
    {
        return in_array($type, self::$TEXT_TYPES);
    }

    /**
     * Returns true if values for the type are numeric.
     *
     * @param string $type The Propel type to check.
     *
     * @return boolean True if values for the type need to be quoted.
     */
    public static function isNumericType($type)
    {
        return in_array($type, self::$NUMERIC_TYPES);
    }

    /**
     * Returns true if values for the type are boolean.
     *
     * @param string $type The Propel type to check.
     *
     * @return boolean True if values for the type need to be quoted.
     */
    public static function isBooleanType($type)
    {
        return in_array($type, self::$BOOLEAN_TYPES);
    }

    /**
     * Returns true if type is a LOB type (i.e. would be handled by Blob/Clob class).
     *
     * @param string $type Propel type to check.
     *
     * @return boolean
     */
    public static function isLobType($type)
    {
        return in_array($type, self::$LOB_TYPES);
    }

    /**
     * Convenience method to indicate whether a passed-in PHP type is a primitive.
     *
     * @param string $phpType The PHP type to check
     *
     * @return boolean Whether the PHP type is a primitive (string, int, boolean, float)
     */
    public static function isPhpPrimitiveType($phpType)
    {
        return in_array($phpType, ["boolean", "int", "double", "float", "string"]);
    }

    /**
     * Convenience method to indicate whether a passed-in PHP type is a numeric primitive.
     *
     * @param string $phpType The PHP type to check
     *
     * @return boolean Whether the PHP type is a primitive (string, int, boolean, float)
     */
    public static function isPhpPrimitiveNumericType($phpType)
    {
        return in_array($phpType, ["boolean", "int", "double", "float"]);
    }

    /**
     * Convenience method to indicate whether a passed-in PHP type is an object.
     *
     * @param string $phpType The PHP type to check
     *
     * @return boolean
     */
    public static function isPhpObjectType($phpType)
    {
        return (!self::isPhpPrimitiveType($phpType) && !in_array($phpType, ["resource", "array"]));
    }

    /**
     * Convenience method to indicate whether a passed-in PHP type is an array.
     *
     * @param string $phpType The PHP type to check
     *
     * @return boolean
     */
    public static function isPhpArrayType($phpType)
    {
        return strtoupper($phpType) === self::PHP_ARRAY;
    }
}
