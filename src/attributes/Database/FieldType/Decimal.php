<?php
namespace DatabaseInspect\Attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException;
use DatabaseInspect\Attributes\ValueObjectInterface;

class Decimal extends FieldType implements ValueObjectInterface
{
    protected $digits;

    protected $decimals;

    public function __construct($digits, $decimals)
    {
        if (!is_int($digits)) {
            throw new InvalidNativeArgumentException($digits, ['int']);
        }

        if (!is_int($decimals)) {
            throw new InvalidNativeArgumentException($decimals, ['int']);
        }

        $this->digits = $digits;
        $this->decimals = $decimals;
    }

    /**
     * @param int digits
     * @param int decimals
     * @return static
     */
    public static function fromNative()
    {
        $digits = func_get_arg(0);
        $decimals = func_get_arg(1);

        return new static($digits, $decimals);
    }

    public function toNative()
    {
        return 'decimal(' . $this->digits . ',' . $this->decimals . ')';
    }
}
