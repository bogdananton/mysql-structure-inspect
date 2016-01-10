<?php
namespace tests\unit\attributes\Database\FieldType\Text;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string "text".
     */
    public function testReturnsTheStringText()
    {
        $instance = new FieldType\Text();
        $result = $instance->toNative();

        static::assertEquals('text', $result);
    }
}
