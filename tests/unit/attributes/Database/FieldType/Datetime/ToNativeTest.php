<?php
namespace tests\unit\attributes\Database\FieldType\Datetime;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string "datetime".
     */
    public function testReturnsTheStringDatetime()
    {
        $instance = new FieldType\Datetime();
        $result = $instance->toNative();

        static::assertEquals('datetime', $result);
    }
}
