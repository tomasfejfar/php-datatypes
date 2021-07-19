<?php

namespace Keboola\Datatype\Definition;

use Keboola\Datatype\Definition\Exception\InvalidLengthException;
use Keboola\Datatype\Definition\Exception\InvalidOptionException;
use Keboola\Datatype\Definition\Exception\InvalidTypeException;

/**
 * Class Teradata
 *
 * https://docs.teradata.com/r/Ri8d7iL59tIPr1FZNKPLMw/TQAE5zgqV8pvyhrySc7ZVg
 */
class Teradata extends Common
{
    //https://docs.teradata.com/r/Ri8d7iL59tIPr1FZNKPLMw/DlfSbsVEC48atCIcADa5IA
    /* numbers */
    const TYPE_BYTEINT = 'BYTEINT'; // -128 to 127, 1B, BYTEINT [ attributes [...] ]
    const TYPE_BIGINT = 'BIGINT'; // 64bit signed, 7B, BIGINT [ attributes [...] ]
    const TYPE_SMALLINT = 'SMALLINT'; //  -32768 to 32767, 2B, SMALLINT [ attributes [...] ]
    const TYPE_INTEGER = 'INTEGER'; // 32bit signed, 4B, { INTEGER | INT } [ attributes [...] ]
    const TYPE_INT = 'INT'; // = INTEGER
    const TYPE_DECIMAL = 'DECIMAL'; // fixed length up to 16B
    // DECIMAL [(n[,m])], { DECIMAL | DEC | NUMERIC } [ ( n [, m ] ) ] [ attributes [...] ], 12.4567 : n = 6; m = 4.
    // n: 1-38 ; m 0-n, default when no n nor m -> DECIMAL(5, 0)., default when n is specified -> DECIMAL(n, 0).
    const TYPE_NUMERIC = 'NUMERIC'; // = DECIMAL
    const TYPE_DEC = 'DEC'; // = DECIMAL
    const TYPE_FLOAT = 'FLOAT'; // 8B, { FLOAT | REAL | DOUBLE PRECISION } [ attributes [...] ]
    const TYPE_DOUBLE_PRECISION = 'DOUBLE PRECISION'; // = FLOAT
    const TYPE_REAL = 'REAL'; // = FLOAT
    const TYPE_NUMBER = 'NUMBER'; // 1-20B,  NUMBER(n[,m]) / NUMBER[(*[,m])], as DECIMAL but variable-length
    // n: 1-38 ; m 0-n, default when no n nor m -> DECIMAL(5, 0)., default when n is specified DECIMAL(n, 0).

    /* Byte */
    const TYPE_BYTE = 'BYTE'; // BYTE [ ( n ) ] [ attributes [...] ]; n Max 64000 Bytes; fixed length
    const TYPE_VARBYTE = 'VARBYTE'; // VARBYTE ( n ) [ attributes [...] ]; n Max 64000 Bytes; VARIABLE length
    const TYPE_BLOB = 'BLOB';
    //  { BINARY LARGE OBJECT | BLOB }
    //  [ ( n [ K | M | G ] ) ]
    //  [ attribute [...] ]
    // n - amount of
    //  Bytes - no unit
    //  K - K - max 2047937
    //  M - M - max 1999
    //  G - G - 1 only
    const TYPE_BINARY_LARGE_OBJECT = 'BINARY LARGE OBJECT';
    /* DateTime */
    const TYPE_DATE = 'DATE'; // DATE [ attributes [...] ]
    const TYPE_TIME = 'TIME'; // TIME [ ( n ) ] [ attributes [...] ]; n = A single digit representing the number of digits in the fractional portion of the SECOND field. '11:37:58.12345' n = 5; '11:37:58' n = 0
    const TYPE_TIMESTAMP = 'TIMESTAMP'; //  TIMESTAMP [ ( n ) ] [ attributes [...] ]
    // '1999-01-01 23:59:59.1234' n = 4
    // '1999-01-01 23:59:59' n = 0

    const TYPE_TIME_WITH_ZONE = 'TIME_WITH_ZONE'; // as TIME but
    // TIME [ ( n ) ] WITH ZONE [ attributes [...] ]
    // where insert value as a number from -12.59 to +14.00  23:59:59.1234 +02:00
    const TYPE_TIMESTAMP_WITH_ZONE = 'TIMESTAMP_WITH_ZONE'; // same as TYPE_TIME_WITH_ZONE
    /* character */
    const TYPE_CHAR = 'CHAR'; // [(n)]
    const TYPE_CHARACTER = 'CHARACTER'; // = CHAR
    //  { { CHARACTER | CHAR } [ ( n ) ]
    //  [ { CHARACTER | CHAR } SET server_character_set ] |
    //      GRAPHIC [ ( n ) ]
    //  } [ attributes [...] ]
    // n = length, static
    // 64000 for LATIN charset, 32000 for UNICODE,GRAPHIC,KANJISJIS

    const TYPE_VARCHAR = 'VARCHAR';
    //  {
    //      { VARCHAR | { CHARACTER | CHAR } VARYING } ( n )
    //      [ { CHARACTER | CHAR } SET ] server_character_set |
    //      LONG VARCHAR |
    //      VARGRAPHIC ( n ) |
    //      LONG VARGRAPHIC
    //  } [ attributes [...] ]
    // n = length, variable
    // 64000 for LATIN charset, 32000 for UNICODE,GRAPHIC,KANJISJIS
    const TYPE_CHARV = 'CHAR VARYING'; // = VARCHAR
    const TYPE_CHARACTERV = 'CHARACTER VARYING'; // = VARCHAR
    const TYPE_VARGRAPHIC = 'VARGRAPHIC'; // = VARCHAR
    // = VARCHAR but without n
    const TYPE_LONG_VARCHAR = 'LONG VARCHAR';
    const TYPE_LONG_VARGRAPHIC = 'LONG VARGRAPHIC';
    const TYPE_CLOB = 'CLOB';
    // { CHARACTER LARGE OBJECT | CLOB }
    // [ ( n [ K | M | G ] ) ]
    // [ { CHARACTER | CHAR } SET { LATIN | UNICODE } ]
    // [ attribute [...] ]
    //  n - amount of
    //   Bytes - no unit
    //   K - K - max 2047937 for Latin, 1023968 for Unicode
    //   M - M - max 1999 for Latin, 999 for Unicode
    //   G - G - 1 and for LATIN only
    const TYPE_CHARACTER_LARGE_OBJECT = 'CHARACTER LARGE OBJECT'; // = CLOB
    // Following types are listed due compatibility but they are treated as string
    /* Array */
    // not implemented, because arrays are considered as user defined types

    /* Period */
    // n represents fraction of seconds as in TIME / TIMESTAMP
    const TYPE_PERIOD_DATE = 'PERIOD(DATE)'; // PERIOD(DATE)
    const TYPE_PERIOD_TIME = 'PERIOD(TIME)';  // PERIOD(TIME [ ( n ) ] )
    const TYPE_PERIOD_TIMESTAMP = 'PERIOD TIMESTAMP';  // PERIOD(TIMESTAMP [ ( n ) ] )
    const TYPE_PERIOD_TIME_WITH_ZONE = 'PERIOD TIME WITH_ZONE';  // PERIOD(TIME [ ( n ) ] _WITH_ZONE )
    const TYPE_PERIOD_TIMESTAMP_WITH_ZONE = 'PERIOD TIMESTAMP WITH_ZONE';  // PERIOD(TIMESTAMP [ ( n ) ] _WITH_ZONE )
    /* Intervals */
    // n is always number of digits, m number of decimal digits for seconds. INTERVAL HOUR(1) TO SECOND(2) = '9:59:59.99'
    const TYPE_INTERVAL_SECOND = 'INTERVAL SECOND'; // INTERVAL SECOND [(n;[m])]
    const TYPE_INTERVAL_MINUTE = 'INTERVAL MINUTE'; // INTERVAL MINUTE [(n)]
    const TYPE_INTERVAL_MINUTE_TO_SECOND = 'INTERVAL MINUTE TO SECOND'; // INTERVAL MINUTE [(n)] TO SECOND [(m)]
    const TYPE_INTERVAL_HOUR = 'INTERVAL HOUR'; // INTERVAL HOUR [(n)]
    const TYPE_INTERVAL_HOUR_TO_SECOND = 'INTERVAL HOUR TO SECOND'; // INTERVAL HOUR [(n)] TO SECOND [(m)]
    const TYPE_INTERVAL_HOUR_TO_MINUTE = 'INTERVAL HOUR TO MINUTE'; // INTERVAL HOUR [(n)] TO MINUTE
    const TYPE_INTERVAL_DAY = 'INTERVAL DAY'; // INTERVAL DAY [(n)]
    const TYPE_INTERVAL_DAY_TO_SECOND = 'INTERVAL DAY TO SECOND'; // INTERVAL DAY [(n)] TO SECOND [(m)]
    const TYPE_INTERVAL_DAY_TO_MINUTE = 'INTERVAL DAY TO MINUTE'; // INTERVAL DAY [(n)] TO MINUTE
    const TYPE_INTERVAL_DAY_TO_HOUR = 'INTERVAL DAY TO HOUR'; // INTERVAL DAY [(n)] TO HOUR
    const TYPE_INTERVAL_MONTH = 'INTERVAL MONTH'; // INTERVAL MONTH
    const TYPE_INTERVAL_YEAR = 'INTERVAL YEAR'; // INTERVAL YEAR [(n)]
    const TYPE_INTERVAL_YEAR_TO_MONTH = 'INTERVAL YEAR TO MONTH'; // INTERVAL YEAR [(n)] TO MONTH
    // User Defined Types (UDP) are not supported

    // default lengths for different kinds of types. Used max values
    const DEFAULT_BLOB_LENGTH = '1G';
    const DEFAULT_BYTE_LENGTH = 64000;
    const DEFAULT_DATETIME_DIGIT_LENGTH = 4;
    const DEFAULT_DECIMAL_LENGTH = '38,38';
    const DEFAULT_LATIN_CHAR_LENGTH = 64000;
    const DEFAULT_LATIN_CLOB_LENGTH = '1999M';
    const DEFAULT_NON_LATIN_CHAR_LENGTH = 32000;
    const DEFAULT_NON_LATIN_CLOB_LENGTH = '999M';
    const DEFAULT_SECOND_PRECISION_LENGTH = 6;
    const DEFAULT_VALUE_TO_SECOND_PRECISION_LENGTH = '4,6';

    // types where length isnt at the end of the type
    const COMPLEX_LENGTH_DICT = [
        self::TYPE_TIME_WITH_ZONE => 'TIME (%d) WITH TIME ZONE',
        self::TYPE_TIMESTAMP_WITH_ZONE => 'TIMESTAMP (%d) WITH TIME ZONE',
        self::TYPE_PERIOD_TIME => 'PERIOD(TIME (%d))',
        self::TYPE_PERIOD_TIMESTAMP => 'PERIOD(TIMESTAMP (%d))',
        self::TYPE_PERIOD_TIME_WITH_ZONE => 'PERIOD(TIME (%d) WITH TIME ZONE)',
        self::TYPE_PERIOD_TIMESTAMP_WITH_ZONE => 'PERIOD(TIMESTAMP (%d) WITH TIME ZONE)',
        self::TYPE_INTERVAL_DAY_TO_MINUTE => 'INTERVAL DAY (%d) TO MINUTE',
        self::TYPE_INTERVAL_DAY_TO_HOUR => 'INTERVAL DAY (%d) TO HOUR',
        self::TYPE_INTERVAL_HOUR_TO_MINUTE => 'INTERVAL HOUR (%d) TO MINUTE',
        self::TYPE_INTERVAL_MINUTE_TO_SECOND => 'INTERVAL MINUTE (%d) TO SECOND (%d)',
        self::TYPE_INTERVAL_HOUR_TO_SECOND => 'INTERVAL HOUR (%d) TO SECOND (%d)',
        self::TYPE_INTERVAL_DAY_TO_SECOND => 'INTERVAL DAY (%d) TO SECOND (%d)',
        self::TYPE_INTERVAL_YEAR_TO_MONTH => 'INTERVAL YEAR (%d) TO MONTH',

    ];
    /**
     * Types without precision, scale, or length
     * This used to separate types when column is retrieved from database
     */
    const TYPES_WITHOUT_LENGTH = [
        self::TYPE_BYTEINT,
        self::TYPE_BIGINT,
        self::TYPE_SMALLINT,
        self::TYPE_INTEGER,
        self::TYPE_INT, //
        self::TYPE_FLOAT,
        self::TYPE_DOUBLE_PRECISION, //
        self::TYPE_REAL, //
        self::TYPE_PERIOD_DATE,
        self::TYPE_LONG_VARCHAR,
        self::TYPE_LONG_VARGRAPHIC,
    ];
    // syntax "TYPEXXX <length>" even if the length is not a single value, such as 38,38
    const TYPES_WITH_SIMPLE_LENGTH = [
        self::TYPE_BYTE,
        self::TYPE_VARBYTE,
        self::TYPE_TIME,
        self::TYPE_TIMESTAMP,
        self::TYPE_CHAR,
        self::TYPE_CHARACTER, //
        self::TYPE_VARCHAR,
        self::TYPE_CHARV, //
        self::TYPE_CHARACTERV,
        self::TYPE_VARGRAPHIC,
        self::TYPE_INTERVAL_MINUTE,
        self::TYPE_INTERVAL_HOUR,
        self::TYPE_INTERVAL_DAY,
        self::TYPE_INTERVAL_MONTH,
        self::TYPE_INTERVAL_YEAR,
        self::TYPE_DECIMAL,
        self::TYPE_NUMERIC, // alias
        self::TYPE_DEC, //
        self::TYPE_NUMBER,
        self::TYPE_BLOB, // ?????
        self::TYPE_BINARY_LARGE_OBJECT, //
        self::TYPE_CLOB, // ???
        self::TYPE_CHARACTER_LARGE_OBJECT, //
        self::TYPE_INTERVAL_SECOND,

    ];
    //https://docs.teradata.com/r/rgAb27O_xRmMVc_aQq2VGw/6CYL2QcAvXykzEc8mG__Xg
    const CODE_TO_TYPE = [
        'I8' => self::TYPE_BIGINT,
        'BO' => self::TYPE_BLOB,
        'BF' => self::TYPE_BYTE,
        'BV' => self::TYPE_VARBYTE,
        'I1' => self::TYPE_BYTEINT,
        'CF' => self::TYPE_CHARACTER,
        'CV' => self::TYPE_VARCHAR,
        'CO' => self::TYPE_CLOB,
        'D' => self::TYPE_DECIMAL,
        'DA' => self::TYPE_DATE,
        'F' => self::TYPE_FLOAT,
        'I' => self::TYPE_INTEGER,
        'DY' => self::TYPE_INTERVAL_DAY,
        'DH' => self::TYPE_INTERVAL_DAY_TO_HOUR,
        'DM' => self::TYPE_INTERVAL_DAY_TO_MINUTE,
        'DS' => self::TYPE_INTERVAL_DAY_TO_SECOND,
        'HR' => self::TYPE_INTERVAL_HOUR,
        'HM' => self::TYPE_INTERVAL_HOUR_TO_MINUTE,
        'HS' => self::TYPE_INTERVAL_HOUR_TO_SECOND,
        'MI' => self::TYPE_INTERVAL_MINUTE,
        'MS' => self::TYPE_INTERVAL_MINUTE_TO_SECOND,
        'MO' => self::TYPE_INTERVAL_MONTH,
        'SC' => self::TYPE_INTERVAL_SECOND,
        'YR' => self::TYPE_INTERVAL_YEAR,
        'YM' => self::TYPE_INTERVAL_YEAR_TO_MONTH,
        'N' => self::TYPE_NUMBER,
        'PD' => self::TYPE_PERIOD_DATE,
        'PT' => self::TYPE_PERIOD_TIME,
        'PZ' => self::TYPE_PERIOD_TIME_WITH_ZONE,
        'PS' => self::TYPE_PERIOD_TIMESTAMP,
        'PM' => self::TYPE_PERIOD_TIMESTAMP_WITH_ZONE,
        'I2' => self::TYPE_SMALLINT,
        'AT' => self::TYPE_TIME,
        'TS' => self::TYPE_TIMESTAMP,
        'TZ' => self::TYPE_TIME_WITH_ZONE,
        'SZ' => self::TYPE_TIMESTAMP_WITH_ZONE,
    ];
    const TYPES = [
        self::TYPE_BIGINT,
        self::TYPE_BLOB,
        self::TYPE_BYTE,
        self::TYPE_VARBYTE,
        self::TYPE_BYTEINT,
        self::TYPE_CHARACTER,
        self::TYPE_VARCHAR,
        self::TYPE_CLOB,
        self::TYPE_DECIMAL,
        self::TYPE_DATE,
        self::TYPE_FLOAT,
        self::TYPE_INTEGER,
        self::TYPE_INTERVAL_DAY,
        self::TYPE_INTERVAL_DAY_TO_HOUR,
        self::TYPE_INTERVAL_DAY_TO_MINUTE,
        self::TYPE_INTERVAL_DAY_TO_SECOND,
        self::TYPE_INTERVAL_HOUR,
        self::TYPE_INTERVAL_HOUR_TO_MINUTE,
        self::TYPE_INTERVAL_HOUR_TO_SECOND,
        self::TYPE_INTERVAL_MINUTE,
        self::TYPE_INTERVAL_MINUTE_TO_SECOND,
        self::TYPE_INTERVAL_MONTH,
        self::TYPE_INTERVAL_SECOND,
        self::TYPE_INTERVAL_YEAR,
        self::TYPE_INTERVAL_YEAR_TO_MONTH,
        self::TYPE_NUMBER,
        self::TYPE_PERIOD_DATE,
        self::TYPE_PERIOD_TIME,
        self::TYPE_PERIOD_TIME_WITH_ZONE,
        self::TYPE_PERIOD_TIMESTAMP,
        self::TYPE_PERIOD_TIMESTAMP_WITH_ZONE,
        self::TYPE_SMALLINT,
        self::TYPE_TIME,
        self::TYPE_TIMESTAMP,
        self::TYPE_TIME_WITH_ZONE,
        self::TYPE_TIMESTAMP_WITH_ZONE,

        // aliases
        self::TYPE_INT,
        self::TYPE_CHAR,
        self::TYPE_CHARV,
        self::TYPE_CHARACTERV,
        self::TYPE_VARGRAPHIC,
        self::TYPE_LONG_VARCHAR,
        self::TYPE_LONG_VARGRAPHIC,
        self::TYPE_CHARACTER_LARGE_OBJECT,
        self::TYPE_BINARY_LARGE_OBJECT,
        self::TYPE_NUMERIC,
        self::TYPE_DEC,
        self::TYPE_FLOAT,
        self::TYPE_DOUBLE_PRECISION,
        self::TYPE_REAL,
    ];

    /** @var bool */
    private $isLatin = false;

    /**
     * @param string $type
     * @param array  $options -- length, nullable, default
     * @throws InvalidLengthException
     * @throws InvalidOptionException
     * @throws InvalidTypeException
     */
    public function __construct($type, $options = [])
    {
        if (isset($options['isLatin'])) {
            $this->isLatin = (boolean) $options['isLatin'];
        }

        $this->validateType($type);
        $this->validateLength($type, isset($options['length']) ? $options['length'] : null);
        $diff = array_diff(array_keys($options), ['length', 'nullable', 'default', 'isLatin']);
        if (count($diff) > 0) {
            throw new InvalidOptionException("Option '{$diff[0]}' not supported");
        }
        parent::__construct($type, $options);
    }

    /**
     * @param string $code
     * @return string
     * @throws \Exception
     */
    public static function convertCodeToType($code)
    {
        if (!array_key_exists($code, self::CODE_TO_TYPE)) {
            throw new \Exception("Type code {$code} is not supported");
        }

        return self::CODE_TO_TYPE[$code];
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
     * @return bool
     */
    private function isLatin()
    {
        return $this->isLatin;
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
            // decimals
            case self::TYPE_DECIMAL:
            case self::TYPE_NUMERIC:
            case self::TYPE_DEC:
            // number
            case self::TYPE_NUMBER:
                $out = self::DEFAULT_DECIMAL_LENGTH;
                break;

            case self::TYPE_BLOB:
            case self::TYPE_BINARY_LARGE_OBJECT:
                $out = self::DEFAULT_BLOB_LENGTH;
                break;

            case self::TYPE_CLOB:
            case self::TYPE_CHARACTER_LARGE_OBJECT:
                $out = $this->isLatin() ? self::DEFAULT_LATIN_CLOB_LENGTH : self::DEFAULT_NON_LATIN_CLOB_LENGTH;
                break;

            case self::TYPE_TIME_WITH_ZONE:
            case self::TYPE_TIMESTAMP_WITH_ZONE:
            case self::TYPE_TIMESTAMP:
            case self::TYPE_TIME:
            case self::TYPE_PERIOD_TIME:
            case self::TYPE_PERIOD_TIME_WITH_ZONE:
            case self::TYPE_PERIOD_TIMESTAMP:
            case self::TYPE_PERIOD_TIMESTAMP_WITH_ZONE:
                $out = self::DEFAULT_SECOND_PRECISION_LENGTH;
                break;

            case self::TYPE_INTERVAL_DAY_TO_SECOND:
            case self::TYPE_INTERVAL_MINUTE_TO_SECOND:
            case self::TYPE_INTERVAL_HOUR_TO_SECOND:
            case self::TYPE_INTERVAL_SECOND:
                $out = self::DEFAULT_VALUE_TO_SECOND_PRECISION_LENGTH;
                break;

            case self::TYPE_INTERVAL_DAY_TO_MINUTE:
            case self::TYPE_INTERVAL_DAY_TO_HOUR:
            case self::TYPE_INTERVAL_HOUR_TO_MINUTE:
            case self::TYPE_INTERVAL_YEAR_TO_MONTH:
            case self::TYPE_INTERVAL_MINUTE:
            case self::TYPE_INTERVAL_HOUR:
            case self::TYPE_INTERVAL_DAY:
            case self::TYPE_INTERVAL_MONTH:
            case self::TYPE_INTERVAL_YEAR:
                $out = self::DEFAULT_DATETIME_DIGIT_LENGTH;
                break;

            case self::TYPE_BYTE:
            case self::TYPE_VARBYTE:
                $out = self::DEFAULT_BYTE_LENGTH;
                break;

            case self::TYPE_CHAR:
            case self::TYPE_CHARACTER:
            case self::TYPE_VARCHAR:
            case self::TYPE_CHARV:
            case self::TYPE_CHARACTERV:
            case self::TYPE_VARGRAPHIC:
                $out = $this->isLatin() ? self::DEFAULT_LATIN_CHAR_LENGTH : self::DEFAULT_NON_LATIN_CHAR_LENGTH;
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
     * @param string      $type
     * @param string|null $length
     * @return void
     * @throws InvalidLengthException
     */
    private function validateLength($type, $length = null)
    {
        $valid = true;

        if (in_array($type, self::TYPES_WITHOUT_LENGTH) && !is_null($length)) {
            throw new InvalidLengthException("Type {$type} does not support length definition");
        }

        switch (strtoupper($type)) {
            case self::TYPE_DECIMAL:
            case self::TYPE_NUMERIC:
            case self::TYPE_DEC:
            case self::TYPE_NUMBER:
                $valid = $this->validateNumericLength($length, 38, 38);
                break;
            case self::TYPE_INTERVAL_SECOND:
            case self::TYPE_INTERVAL_MINUTE_TO_SECOND:
            case self::TYPE_INTERVAL_HOUR_TO_SECOND:
            case self::TYPE_INTERVAL_DAY_TO_SECOND:
                $valid = $this->validateNumericLength($length, 4, 6, false);
                break;
            case self::TYPE_TIME:
            case self::TYPE_TIMESTAMP:
            case self::TYPE_TIME_WITH_ZONE:
            case self::TYPE_TIMESTAMP_WITH_ZONE:
            case self::TYPE_PERIOD_TIME:
            case self::TYPE_PERIOD_TIME_WITH_ZONE:
            case self::TYPE_PERIOD_TIMESTAMP:
            case self::TYPE_PERIOD_TIMESTAMP_WITH_ZONE:
                $valid = $this->validateMaxLength($length, 6, 0);
                break;
            case self::TYPE_INTERVAL_MINUTE:
            case self::TYPE_INTERVAL_HOUR:
            case self::TYPE_INTERVAL_DAY:
            case self::TYPE_INTERVAL_MONTH:
            case self::TYPE_INTERVAL_YEAR:
            case self::TYPE_INTERVAL_DAY_TO_MINUTE:
            case self::TYPE_INTERVAL_HOUR_TO_MINUTE:
            case self::TYPE_INTERVAL_DAY_TO_HOUR:
            case self::TYPE_INTERVAL_YEAR_TO_MONTH:
                $valid = $this->validateMaxLength($length, 4);
                break;
            case self::TYPE_BYTE:
            case self::TYPE_VARBYTE:
                $valid = $this->validateMaxLength($length, 64000);
                break;

            case self::TYPE_CHAR:
            case self::TYPE_CHARACTER:
            case self::TYPE_VARCHAR:
            case self::TYPE_CHARV:
            case self::TYPE_CHARACTERV:
            case self::TYPE_VARGRAPHIC:
                $valid = $this->validateMaxLength($length, $this->isLatin() ? 64000 : 32000);
                break;
            case self::TYPE_CLOB:
            case self::TYPE_CHARACTER_LARGE_OBJECT:
                $isLatin = $this->isLatin();
                $valid = $this->validateLOBLength(
                    $length,
                    [
                        'no' => $isLatin ? 2097088000 : 1048544000,
                        'K' => $isLatin ? 2047937 : 1023968,
                        'M' => $isLatin ? 1999 : 999,
                        'G' => $isLatin ? 1 : 0,
                    ]
                );
                break;
            case self::TYPE_BLOB:
            case self::TYPE_BINARY_LARGE_OBJECT:
                $valid = $this->validateLOBLength(
                    $length,
                    [
                        'no' => 2097088000,
                        'K' => 2047937,
                        'M' => 1999,
                        'G' => 1,
                    ]
                );
                break;
        }

        if (!$valid) {
            echo "$type $length";
            throw new InvalidLengthException("'{$length}' is not valid length for {$type}");
        }
    }

    /**
     * @param string|null $length
     * @param array $maxTab table (array) with max values
     * @return bool
     */
    private function validateLOBLength($length, $maxTab)
    {
        if ($this->isEmpty($length)) {
            return true;
        }
        if (!preg_match('/^([1-9]\d*)\s*(M|K|G)?$/', (string) $length, $out)) {
            return false;
        }
        if (count($out) === 2) {
            // no unit
            return $out[1] < $maxTab['noUnit'] && $out[1] >= 1;
        }
        if (count($out) === 3) {
            // with unit
            return $out[1] <= $maxTab[$out[2]] && $out[1] >= 1;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getBasetype()
    {
        switch (strtoupper($this->type)) {
            case self::TYPE_BYTEINT:
            case self::TYPE_INTEGER:
            case self::TYPE_INT:
            case self::TYPE_BIGINT:
            case self::TYPE_SMALLINT:
                $basetype = BaseType::INTEGER;
                break;
            case self::TYPE_DECIMAL:
            case self::TYPE_DEC:
            case self::TYPE_NUMERIC:
            case self::TYPE_NUMBER:
                $basetype = BaseType::NUMERIC;
                break;
            case self::TYPE_FLOAT:
            case self::TYPE_DOUBLE_PRECISION:
            case self::TYPE_REAL:
                $basetype = BaseType::FLOAT;
                break;
            case self::TYPE_DATE:
                $basetype = BaseType::DATE;
                break;
            case self::TYPE_TIME:
            case self::TYPE_TIME_WITH_ZONE:
                $basetype = BaseType::TIMESTAMP;
                break;
            default:
                $basetype = BaseType::STRING;
                break;
        }
        return $basetype;
    }
}
