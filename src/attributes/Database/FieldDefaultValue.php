<?php
namespace DatabaseInspect\Attributes\Database;

use DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Attributes\ValueObjectInterface;

class FieldDefaultValue extends StringLiteral implements ValueObjectInterface
{
    public static function fromNative()
    {
        $value = func_get_arg(0);

        return new static($value);
    }

    public function __construct($value)
    {
        if (!is_scalar($value) && null !== $value) {
            throw new InvalidNativeArgumentException($value, ['string', 'int', 'bool', 'null']);
        }
        $this->value = $value;
    }
}
