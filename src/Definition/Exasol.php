<?php

namespace Keboola\Datatype\Definition;

use Keboola\Datatype\Definition\Exception\InvalidLengthException;
use Keboola\Datatype\Definition\Exception\InvalidOptionException;
use Keboola\Datatype\Definition\Exception\InvalidTypeException;

/**
 * Class Exasol
 *
 * https://docs.exasol.com/sql_references/data_types/datatypedetails.htm
 */
class Exasol extends Common
{
    /* core types */
    const TYPE_DECIMAL = 'DECIMAL'; // DECIMAL(p,s) = s ≤ p ≤ 36
    const TYPE_DOUBLE_PRECISION = 'DOUBLE PRECISION';
    const TYPE_BOOLEAN = 'BOOLEAN';
    const TYPE_DATE = 'DATE';
    const TYPE_TIMESTAMP = 'TIMESTAMP';
    const TYPE_TIMESTAMP_WITH_LOCAL_ZONE = 'TIMESTAMP WITH LOCAL TIME ZONE';
    const TYPE_INTERVAL_YEAR_TO_MONTH = 'INTERVAL_YEAR TO MONTH'; // INTERVAL_YEAR [(p)] TO MONTH
    const TYPE_INTERVAL_DAY_TO_SECOND = 'INTERVAL DAY TO SECOND'; // INTERVAL DAY [(p)] TO SECOND [(fp)]
    const TYPE_GEOMETRY = 'GEOMETRY'; // GEOMETRY [(srid)]
    const TYPE_HASHTYPE = 'HASHTYPE'; // HASHTYPE[(n BYTE | m BIT)]
    const TYPE_CHAR = 'CHAR'; // CHAR(n)
    const TYPE_VARCHAR = 'VARCHAR'; // VARCHAR(n)

    // aliases
    const TYPE_BIGINT = 'BIGINT'; // BIGINT = DECIMAL(36,0)
    const TYPE_INT = 'INT'; // INT = DECIMAL(18,0)
    const TYPE_INTEGER = 'INTEGER'; // INTEGER = DECIMAL(18,0)
    const TYPE_SHORTINT = 'SHORTINT'; // SHORTINT = DECIMAL(9,0)
    const TYPE_SMALLINT = 'SMALLINT'; // SMALLINT = DECIMAL(9,0)
    const TYPE_TINYINT = 'TINYINT'; // TINYINT = DECIMAL(3,0)

    const TYPE_BOOL = 'BOOL'; // BOOL = BOOLEAN
    const TYPE_CHAR_VARYING = 'CHAR VARYING'; // CHAR VARYING(n) = VARCHAR(n), 1 ≤ n ≤ 2,000,000
    const TYPE_CHARACTER = 'CHARACTER'; // CHARACTER = CHAR(1)
    const TYPE_CHARACTER_LARGE_OBJECT = 'CHARACTER LARGE OBJECT'; // CHARACTER LARGE OBJECT(n) = VARCHAR(n) , 1 ≤ n ≤ 2,000,000
    const TYPE_CHARACTER_VARYING = 'CHARACTER VARYING'; // CHARACTER VARYING(n) = VARCHAR(n) , 1 ≤ n ≤ 2,000,000
    const TYPE_CLOB = 'CLOB'; // CLOB(n) = VARCHAR(n) , 1 ≤ n ≤ 2,000,000
    const TYPE_DEC = 'DEC'; // DEC(p,s) = s ≤ p ≤ 36
    const TYPE_LONG_VARCHAR = 'LONG VARCHAR'; // LONG VARCHAR = VARCHAR(2000000)
    const TYPE_NCHAR = 'NCHAR'; // NCHAR(n) = CHAR(n)
    const TYPE_NUMBER = 'NUMBER'; // NUMBER(p,s) = DECIMAL(p,s) = s ≤ p ≤ 36
    const TYPE_NUMERIC = 'NUMERIC'; // NUMERIC(p,s) = DECIMAL(p,s) = s ≤ p ≤ 36
    const TYPE_NVARCHAR = 'NVARCHAR'; // NVARCHAR(n) = VARCHAR(n) , 1 ≤ n ≤ 2,000,000
    const TYPE_NVARCHAR2 = 'NVARCHAR2'; // NVARCHAR2(n) = VARCHAR(n) , 1 ≤ n ≤ 2,000,000
    const TYPE_VARCHAR2 = 'VARCHAR2'; // VARCHAR2(n) = VARCHAR(n),  1 ≤ n ≤ 2,000,000
    const TYPE_DOUBLE = 'DOUBLE'; // DOUBLE = DOUBLE PRECISION
    const TYPE_FLOAT = 'FLOAT'; // FLOAT = DOUBLE PRECISION
    const TYPE_REAL = 'REAL'; // REAL = DOUBLE PRECISION

    // default lengths for different kinds of types. Used max values
    const MAX_DECIMAL_LENGTH = '36,36'; // max is 36.36, default 18,0
    const MAX_CHAR_LENGTH = 2000;
    const MAX_VARCHAR_LENGTH = 2000000;
    const MAX_GEOMETRY_LENGTH = 4294967295; // max value
    const MAX_HASH_LENGTH = '1024 BYTE'; // max value
    // types where length isnt at the end of the type
    const COMPLEX_LENGTH_DICT = [
        self::TYPE_INTERVAL_YEAR_TO_MONTH => 'INTERVAL_YEAR %d TO MONTH',
        self::TYPE_INTERVAL_DAY_TO_SECOND => 'INTERVAL DAY %d TO SECOND %d',
    ];
    /**
     * Types without precision, scale, or length
     * This used to separate types when column is retrieved from database
     */
    const TYPES_WITHOUT_LENGTH = [
        self::TYPE_BOOLEAN,
        self::TYPE_DOUBLE_PRECISION,
        self::TYPE_DATE,
        self::TYPE_TIMESTAMP,
        self::TYPE_TIMESTAMP_WITH_LOCAL_ZONE,

        self::TYPE_BIGINT,
        self::TYPE_BOOL,
        self::TYPE_CHARACTER,
        self::TYPE_DOUBLE,
        self::TYPE_FLOAT,
        self::TYPE_INT,
        self::TYPE_INTEGER,
        self::TYPE_LONG_VARCHAR,
        self::TYPE_REAL,
        self::TYPE_SHORTINT,
        self::TYPE_SMALLINT,
        self::TYPE_TINYINT,
    ];
    // syntax "TYPEXXX <length>" even if the length is not a single value, such as 38,38
    const TYPES_WITH_SIMPLE_LENGTH = [
        self::TYPE_DECIMAL,
        self::TYPE_GEOMETRY,
        self::TYPE_CHAR,
        self::TYPE_VARCHAR,
        self::TYPE_HASHTYPE,

        self::TYPE_CHAR_VARYING,
        self::TYPE_CHARACTER_LARGE_OBJECT,
        self::TYPE_CHARACTER_VARYING,
        self::TYPE_CLOB,
        self::TYPE_DEC,
        self::TYPE_NCHAR,
        self::TYPE_NUMBER,
        self::TYPE_NUMERIC,
        self::TYPE_NVARCHAR,
        self::TYPE_NVARCHAR2,
        self::TYPE_VARCHAR2,

    ];
    const TYPES = [
        self::TYPE_DECIMAL,
        self::TYPE_DOUBLE_PRECISION,
        self::TYPE_BOOLEAN,
        self::TYPE_DATE,
        self::TYPE_TIMESTAMP,
        self::TYPE_TIMESTAMP_WITH_LOCAL_ZONE,
        self::TYPE_INTERVAL_YEAR_TO_MONTH,
        self::TYPE_INTERVAL_DAY_TO_SECOND,
        self::TYPE_GEOMETRY,
        self::TYPE_HASHTYPE,
        self::TYPE_CHAR,
        self::TYPE_VARCHAR,

        // aliases
        self::TYPE_BIGINT,
        self::TYPE_BOOL,
        self::TYPE_CHARACTER,
        self::TYPE_DOUBLE,
        self::TYPE_FLOAT,
        self::TYPE_INT,
        self::TYPE_INTEGER,
        self::TYPE_LONG_VARCHAR,
        self::TYPE_REAL,
        self::TYPE_SHORTINT,
        self::TYPE_SMALLINT,
        self::TYPE_TINYINT,
        self::TYPE_CHAR_VARYING,
        self::TYPE_CHARACTER_LARGE_OBJECT,
        self::TYPE_CHARACTER_VARYING,
        self::TYPE_CLOB,
        self::TYPE_DEC,
        self::TYPE_NCHAR,
        self::TYPE_NUMBER,
        self::TYPE_NUMERIC,
        self::TYPE_NVARCHAR,
        self::TYPE_NVARCHAR2,
        self::TYPE_VARCHAR2,
    ];

    /**
     * @param string $type
     * @param array $options -- length, nullable, default
     * @throws InvalidLengthException
     * @throws InvalidOptionException
     * @throws InvalidTypeException
     */
    public function __construct($type, $options = [])
    {
        $this->validateType($type);
        $length = isset($options['length']) ? $options['length'] : null;
        $this->validateLength($type, $length);

        /*
         * because
         * NUMBER = DOUBLE PRECISION
         * NUMBER(p,s) = DECIMAL(p,s)
         */
        if ($type === self::TYPE_NUMBER && $length === null) {
            $type = self::TYPE_DOUBLE_PRECISION;
        }

        $diff = array_diff(array_keys($options), ['length', 'nullable', 'default']);
        if (count($diff) > 0) {
            throw new InvalidOptionException("Option '{$diff[0]}' not supported");
        }
        parent::__construct($type, $options);
    }

    /**
     * @return string
     */
    public function getSQLDefinition()
    {
        $type = $this->getType();
        $definition = $type;
        if (!in_array($definition, self::TYPES_WITHOUT_LENGTH)) {
            $length = $this->getLength() ?: $this->getDefaultLength();
            // length is set, use it
            if ($length !== null && $length !== '') {
                if (in_array($definition, self::TYPES_WITH_SIMPLE_LENGTH)) {
                    $definition .= sprintf(' (%s)', $length);
                } elseif (array_key_exists($definition, self::COMPLEX_LENGTH_DICT)) {
                    $definition = $this->buildComplexLength($type, $length);
                }
            }
        }

        if (!$this->isNullable()) {
            $definition .= ' NOT NULL';
        }
        if ($this->getDefault() !== null) {
            $definition .= ' DEFAULT ' . $this->getDefault();
        }
        return $definition;
    }

    /**
     * builds SQL definition for types which don't just append the length behind the type name
     *
     * @param string $type
     * @param string|int|null $lengthString
     * @return string
     */
    private function buildComplexLength($type, $lengthString)
    {
        $parts = explode(',', (string) $lengthString);
        return sprintf(self::COMPLEX_LENGTH_DICT[$type], ...$parts);
    }

    /**
     * Unlike RS or SNFLK which sets default values for types to max
     * Synapse sets default length to min, so when length is empty we need to set maximum values
     * to maintain same behavior as with RS and SNFLK
     *
     * @return int|string|null
     */
    private function getDefaultLength()
    {
        $out = null;
        switch ($this->type) {
            case self::TYPE_DECIMAL:
            case self::TYPE_DEC:
            case self::TYPE_NUMBER:
            case self::TYPE_NUMERIC:
                $out = self::MAX_DECIMAL_LENGTH;
                break;
            case self::TYPE_INTERVAL_YEAR_TO_MONTH:
                $out = 2;
                break;
            case self::TYPE_INTERVAL_DAY_TO_SECOND:
                $out = '2,3';
                break;
            case self::TYPE_CHAR:
            case self::TYPE_NCHAR:
                $out = self::MAX_CHAR_LENGTH;
                break;
            case self::TYPE_VARCHAR:
            case self::TYPE_CHAR_VARYING:
            case self::TYPE_CHARACTER_LARGE_OBJECT:
            case self::TYPE_CHARACTER_VARYING:
            case self::TYPE_CLOB:
            case self::TYPE_NVARCHAR:
            case self::TYPE_NVARCHAR2:
            case self::TYPE_VARCHAR2:
                $out = self::MAX_VARCHAR_LENGTH;
                break;
            case self::TYPE_GEOMETRY:
                $out = self::MAX_GEOMETRY_LENGTH;
                break;
            case self::TYPE_HASHTYPE:
                $out = self::MAX_HASH_LENGTH;
                break;
        }

        return $out;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'type' => $this->getType(),
            'length' => $this->getLength(),
            'nullable' => $this->isNullable(),
        ];
    }

    /**
     * @param string $type
     * @return void
     * @throws InvalidTypeException
     */
    private function validateType($type)
    {
        if (!in_array(strtoupper($type), $this::TYPES, true)) {
            throw new InvalidTypeException(sprintf('"%s" is not a valid type', $type));
        }
    }

    /**
     * @param string $type
     * @param string|null $length
     * @return void
     * @throws InvalidLengthException
     */
    private function validateLength($type, $length = null)
    {
        $valid = true;

        switch (strtoupper($type)) {
            case self::TYPE_DECIMAL:
            case self::TYPE_DEC:
            case self::TYPE_NUMBER:
            case self::TYPE_NUMERIC:
                $valid = $this->validateNumericLength($length, 36, 36, true);
                break;
            case self::TYPE_INTERVAL_YEAR_TO_MONTH:
                $valid = $this->validateMaxLength($length, 9);
                break;
            case self::TYPE_INTERVAL_DAY_TO_SECOND:
                $exploded = explode(',', (string) $length);
                $valid = $this->validateMaxLength((isset($exploded[0]) ? $exploded[0] : ''), 9)
                    && $this->validateMaxLength((isset($exploded[1]) ? $exploded[1] : ''), 9, 0);
                break;
            case self::TYPE_HASHTYPE:
                if ($this->isEmpty($length)) {
                    $valid = true;
                    break;
                }
                if (preg_match('/(?<val>[1-9]+\d*)\s*(?<unit>BYTE|BIT)/i', (string) $length, $matched)) {
                    $val = $matched['val'];
                    $unit = strtoupper($matched['unit']);

                    $limits = [
                        'BYTE' => [1, 1024],
                        'BIT' => [8, 8192],
                    ];
                    $valid = $limits[$unit][0] <= $val && $val <= $limits[$unit][1];
                } else {
                    $valid = false;
                }
                break;
            case self::TYPE_CHAR:
            case self::TYPE_NCHAR:
                $valid = $this->validateMaxLength($length, self::MAX_CHAR_LENGTH);
                break;

            case self::TYPE_GEOMETRY:
                $valid = $this->validateMaxLength($length, self::MAX_GEOMETRY_LENGTH);
                break;
            case self::TYPE_VARCHAR:
            case self::TYPE_CHAR_VARYING:
            case self::TYPE_CHARACTER_LARGE_OBJECT:
            case self::TYPE_CHARACTER_VARYING:
            case self::TYPE_CLOB:
            case self::TYPE_NVARCHAR:
            case self::TYPE_NVARCHAR2:
            case self::TYPE_VARCHAR2:
                $valid = $this->validateMaxLength($length, self::MAX_VARCHAR_LENGTH);
                break;
        }

        if (!$valid) {
            throw new InvalidLengthException("'{$length}' is not valid length for {$type}");
        }
    }


    /**
     * @return string
     */
    public function getBasetype()
    {
        switch (strtoupper($this->type)) {
            case self::TYPE_DECIMAL:
            case self::TYPE_DEC:
            case self::TYPE_NUMBER:
            case self::TYPE_NUMERIC:
                $basetype = BaseType::NUMERIC;
                break;
            case self::TYPE_DOUBLE_PRECISION:
            case self::TYPE_DOUBLE:
            case self::TYPE_FLOAT:
            case self::TYPE_REAL:
                $basetype = BaseType::FLOAT;
                break;
            case self::TYPE_INT:
            case self::TYPE_INTEGER:
            case self::TYPE_BIGINT:
            case self::TYPE_SHORTINT:
            case self::TYPE_SMALLINT:
            case self::TYPE_TINYINT:
                $basetype = BaseType::INTEGER;
                break;
            case self::TYPE_BOOLEAN:
            case self::TYPE_BOOL:
                $basetype = BaseType::BOOLEAN;
                break;
            case self::TYPE_DATE:
                $basetype = BaseType::DATE;
                break;
            case self::TYPE_TIMESTAMP:
            case self::TYPE_TIMESTAMP_WITH_LOCAL_ZONE:
                $basetype = BaseType::TIMESTAMP;
                break;
            default:
                $basetype = BaseType::STRING;
                break;
        }
        return $basetype;
    }
}