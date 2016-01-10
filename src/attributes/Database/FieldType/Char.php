<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Char extends FieldType implements ValueObjectInterface
{
    public static function fromNative()
    {
        $length = func_get_arg(0);

        return new static($length);
    }

    public function toNative()
    {
        return 'char(' . $this->value . ')';
    }
}
