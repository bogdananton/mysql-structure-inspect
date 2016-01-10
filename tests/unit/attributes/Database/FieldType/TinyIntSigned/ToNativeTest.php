<?php
namespace tests\unit\attributes\Database\FieldType\TinyIntSigned;

use DatabaseInspect\Attributes\Database\FieldType;

class ToNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns the string representation of the tinyint with the tinyint length.
     */
    public function testReturnsTheStringRepresentationOfTheTinyintWithTheTinyintLength()
    {
        $instance = new FieldType\TinyIntSigned(81);
        $result = $instance->toNative();

        static::assertEquals('tinyint(81)', $result);
    }
}
