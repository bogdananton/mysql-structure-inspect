<?php
namespace DatabaseInspect\Attributes\Database;

use DatabaseInspect\Attributes\Database\FieldType\Char;
use DatabaseInspect\Attributes\Database\FieldType\Date;
use DatabaseInspect\Attributes\Database\FieldType\Datetime;
use DatabaseInspect\Attributes\Database\FieldType\Decimal;
use DatabaseInspect\Attributes\Database\FieldType\Enum;
use DatabaseInspect\Attributes\Database\FieldType\IntSigned;
use DatabaseInspect\Attributes\Database\FieldType\IntUnsigned;
use DatabaseInspect\Attributes\Database\FieldType\Text;
use DatabaseInspect\Attributes\Database\FieldType\Timestamp;
use DatabaseInspect\Attributes\Database\FieldType\TinyIntSigned;
use DatabaseInspect\Attributes\Database\FieldType\Varchar;
use DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException;
use DatabaseInspect\Attributes\Exceptions\UnexpectedValueException;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Attributes\ValueObjectInterface;

class FieldType extends StringLiteral implements ValueObjectInterface
{
    const REGEX_TYPE_DECIMAL = '/^decimal\(([\d]+)\,([\d]+)\)$/';
    const REGEX_TYPE_CHAR = '/^char\(([\d]+)\)$/';
    const REGEX_TYPE_INT_SIGNED = '/^int\(([\d]+)\)$/';
    const REGEX_TYPE_TINYINT_SIGNED = '/^tinyint\(([\d]+)\)$/';
    const REGEX_TYPE_INT_UNSIGNED = '/^int\(([\d]+)\) unsigned$/';
    const REGEX_TYPE_VARCHAR = '/^varchar\(([\d]+)\)$/';
    const REGEX_TYPE_TIMESTAMP = '/^timestamp$/';
    const REGEX_TYPE_DATETIME = '/^datetime$/';
    const REGEX_TYPE_DATE = '/^date$/';
    const REGEX_TYPE_TEXT = '/^text$/';
    const REGEX_TYPE_ENUM = '/^enum\((.*)\)$/';

    protected $allowedTypes = ['string', 'int', 'float'];

    /**
     * Allows string or numeric values to be passed as input.
     *
     * @throws
     * @param string|int|float $value
     */
    public function __construct($value = '')
    {
        if (!is_string($value) && !is_numeric($value)) {
            throw new InvalidNativeArgumentException($value, $this->allowedTypes);
        }
        $this->value = $value;
    }

    /**
     * Factory method that returns a FieldType object based on the first argument's contents.
     *
     * @param string    raw field representation
     *
     * @throws UnexpectedValueException when a value is given that doesn't follow the field type patterns.
     * @return static
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);

        switch (true) {
            case preg_match(self::REGEX_TYPE_VARCHAR, $value, $matchesVarchar):
                $response = Varchar::fromNative($matchesVarchar[1]);
                break;

            case preg_match(self::REGEX_TYPE_CHAR, $value, $matchesVarchar):
                $response = Char::fromNative($matchesVarchar[1]);
                break;

            case preg_match(self::REGEX_TYPE_TIMESTAMP, $value, $matchesVarchar):
                $response = new Timestamp();
                break;

            case preg_match(self::REGEX_TYPE_DATETIME, $value, $matchesVarchar):
                $response = new Datetime();
                break;

            case preg_match(self::REGEX_TYPE_DATE, $value, $matchesVarchar):
                $response = new Date();
                break;

            case preg_match(self::REGEX_TYPE_TEXT, $value, $matchesVarchar):
                $response = new Text();
                break;

            case preg_match(self::REGEX_TYPE_INT_UNSIGNED, $value, $matchesVarchar):
                $response = IntUnsigned::fromNative($matchesVarchar[1]);
                break;

            case preg_match(self::REGEX_TYPE_INT_SIGNED, $value, $matchesVarchar):
                $response = IntSigned::fromNative($matchesVarchar[1]);
                break;

            case preg_match(self::REGEX_TYPE_DECIMAL, $value, $matchesVarchar):
                $response = Decimal::fromNative((int)$matchesVarchar[1], (int)$matchesVarchar[2]);
                break;

            case preg_match(self::REGEX_TYPE_TINYINT_SIGNED, $value, $matchesVarchar):
                $response = TinyIntSigned::fromNative($matchesVarchar[1]);
                break;

            case preg_match(self::REGEX_TYPE_ENUM, $value, $matchesVarchar):
                $response = Enum::fromNative($matchesVarchar[1]);
                break;

            // @todo Add more cases. http://dev.mysql.com/doc/refman/5.7/en/data-types.html

            default:
                $allowedPatterns = array_values(static::getConstants());
                throw new UnexpectedValueException($value, $allowedPatterns);
                break;
        }

        return $response;
    }

    /**
     * @return string[]
     */
    protected static function getConstants()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}
