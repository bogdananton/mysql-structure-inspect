<?php
namespace DatabaseInspect\Attributes\NullValue;

use DatabaseInspect\Attributes\ValueObjectInterface;

class NullValue implements ValueObjectInterface
{
    /**
     * @throws \BadMethodCallException
     */
    public static function fromNative()
    {
        throw new \BadMethodCallException('Cannot create a NullValue object via this method.');
    }

    /**
     * Returns a new NullValue object
     *
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Returns a string representation of the NullValue object (an empty string)
     *
     * @return string
     */
    public function __toString()
    {
        return \strval(null);
    }

    /**
     * Returns null
     *
     * @return null
     */
    public function toNative()
    {
        return null;
    }
}
