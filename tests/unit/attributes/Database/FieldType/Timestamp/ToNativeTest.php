<?php
namespace tests\unit\attributes\Database\FieldType\Timestamp;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string "timestamp".
     */
    public function testReturnsTheStringTimestamp()
    {
        $instance = new FieldType\Timestamp();
        $result = $instance->toNative();

        static::assertEquals('timestamp', $result);
    }
}
