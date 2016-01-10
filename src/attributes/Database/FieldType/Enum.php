<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Enum extends FieldType implements ValueObjectInterface
{
    const SEPARATOR = ",";

    /**
     * @param string        comma separated entries
     * @return static
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);
        return new static($value);
    }

    public function toNative()
    {
        return 'enum(' . $this->value . ')';
    }
}
