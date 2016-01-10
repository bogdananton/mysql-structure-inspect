<?php
namespace DatabaseInspect\Attributes\String;

use DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException;
use DatabaseInspect\Attributes\NullValue\NullValue;
use DatabaseInspect\Attributes\ValueObjectInterface;

/**
 * Class StringLiteral
 * @package DatabaseInspect\Attributes\String
 */
class StringLiteral implements ValueObjectInterface
{
    /**
     * @var string
     */
    protected $value;

    protected $allowedTypes = ['string'];

    /**
     * When a string is given as the argument then build the object.
     * The non-empty string given is stored as the value object's value.
     * When an non-string value is given then throw exception.
     *
     * @param string $value
     * @todo (maybe) Add check for __toString availability if argument is object.
     */
    public function __construct($value)
    {
        if (!is_string($value)) {
            throw new InvalidNativeArgumentException($value, $this->allowedTypes);
        }
        $this->value = (string)$value;
    }

    /**
     * When called will use first argument to create a new instance.
     * When an invalid native is supplied then throw exception.
     *
     * @return static
     */
    public static function fromNative()
    {
        $value = func_get_arg(0);
        return new static($value);
    }

    /**
     * When called will return the stored string value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * When the input isn't of the same class then return false.
     * When the input is of the same class but with different native value then return false.
     * When the input is of the same class and has the same native value then return true.
     *
     * @param  ValueObjectInterface $stringLiteral
     * @return bool
     */
    public function sameValueAs(ValueObjectInterface $stringLiteral)
    {
        if (\get_class($this) !== get_class($stringLiteral)) {
            return false;
        }
        return $this->toNative() === $stringLiteral->toNative();
    }

    /**
     * When the stored value is a non-empty string then return false.
     * When the stored value is an empty string then return true.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return \strlen($this->toNative()) == 0;
    }

    /**
     * When called will return the stored string value.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toNative();
    }
}
