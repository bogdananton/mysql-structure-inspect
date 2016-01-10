<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Varchar extends FieldType implements ValueObjectInterface
{
    /**
     * @param string    varchar length
     * @return static
     */
    public static function fromNative()
    {
        $length = func_get_arg(0);

        return new static($length);
    }

    public function toNative()
    {
        return 'varchar(' . $this->value . ')';
    }
}
