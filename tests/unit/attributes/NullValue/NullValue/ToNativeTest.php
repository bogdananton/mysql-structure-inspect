<?php
namespace tests\unit\attributes\NullValue\NullValue;

use DatabaseInspect\Attributes\NullValue\NullValue;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns null string.
     */
    public function testReturnsNullString()
    {
        $instance = NullValue::create();
        $value = $instance->toNative();

        static::assertNull($value);
    }
}
