<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Date extends FieldType implements ValueObjectInterface
{
    public static function fromNative()
    {
        throw new \BadMethodCallException('Cannot create a Date object via this method.');
    }

    public function toNative()
    {
        return 'date';
    }
}
