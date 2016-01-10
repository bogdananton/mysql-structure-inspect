<?php
namespace tests\unit\attributes\Database\FieldType\IntUnsigned;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the int with the int length and the unsigned marker.
     */
    public function testReturnsTheStringRepresentationOfTheIntWithTheIntLengthAndTheUnsignedMarker()
    {
        $instance = new FieldType\IntUnsigned(121);
        $result = $instance->toNative();

        static::assertEquals('int(121) unsigned', $result);
    }
}
