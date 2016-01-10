<?php
namespace tests\unit\attributes\Database\FieldType\Enum;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the enum with the options.
     */
    public function testReturnsTheStringRepresentationOfTheEnumWithTheOptions()
    {
        $instance = new FieldType\Enum('1,2,3,4,\'5\',6');
        $result = $instance->toNative();

        static::assertEquals('enum(1,2,3,4,\'5\',6)', $result);
    }
}
