<?php
namespace tests\unit\attributes\Database\FieldType\Char;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the char with the char length.
     */
    public function testReturnTheStringRepresentationOfTheCharWithTheCharLength()
    {
        $instance = new FieldType\Char(4);
        $result = $instance->toNative();

        static::assertEquals('char(4)', $result);
    }
}
