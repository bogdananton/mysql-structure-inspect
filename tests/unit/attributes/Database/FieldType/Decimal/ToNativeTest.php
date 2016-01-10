<?php
namespace tests\unit\attributes\Database\FieldType\Decimal;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the decimal with the digits and decimals.
     */
    public function testReturnsTheStringRepresentationOfTheDecimalWithTheDigitsAndDecimals()
    {
        $instance = new FieldType\Decimal(11, 7);
        $result = $instance->toNative();

        static::assertEquals('decimal(11,7)', $result);
    }
}
