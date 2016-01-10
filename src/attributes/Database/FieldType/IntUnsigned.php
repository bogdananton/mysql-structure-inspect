<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class IntUnsigned extends FieldType implements ValueObjectInterface
{
    public static function fromNative()
    {
        $length = func_get_arg(0);

        return new static($length);
    }

    public function toNative()
    {
        return 'int(' . $this->value . ') unsigned';
    }
}
