<?php
namespace tests\unit\attributes\Database\FieldType\IntSigned;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the int with the int length.
     */
    public function testReturnsTheStringRepresentationOfTheIntWithTheIntLength()
    {
        $instance = new FieldType\IntSigned(144);
        $result = $instance->toNative();

        static::assertEquals('int(144)', $result);
    }
}
