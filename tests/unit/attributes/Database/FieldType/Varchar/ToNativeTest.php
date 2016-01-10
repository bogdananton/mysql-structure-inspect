<?php
namespace tests\unit\attributes\Database\FieldType\Varchar;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the varchar with the length.
     */
    public function testReturnsTheStringRepresentationOfTheVarcharWithTheLength()
    {
        $instance = new FieldType\Varchar(255);
        $result = $instance->toNative();

        static::assertEquals('varchar(255)', $result);
    }
}
