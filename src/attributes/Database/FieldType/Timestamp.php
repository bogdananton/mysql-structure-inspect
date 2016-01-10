<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Timestamp extends FieldType implements ValueObjectInterface
{
    public static function fromNative()
    {
        throw new \BadMethodCallException('Cannot create a Timestamp object via this method.');
    }

    public function toNative()
    {
        return 'timestamp';
    }
}
