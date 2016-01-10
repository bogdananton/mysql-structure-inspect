<?php
namespace tests\unit\attributes\Database\FieldType\Date;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string "date".
     */
    public function testReturnsTheStringDate()
    {
        $instance = new FieldType\Date();
        $result = $instance->toNative();

        static::assertEquals('date', $result);
    }
}
