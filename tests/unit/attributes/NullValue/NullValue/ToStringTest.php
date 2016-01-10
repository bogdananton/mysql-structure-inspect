<?php
namespace tests\unit\attributes\NullValue\NullValue;

use DatabaseInspect\Attributes\NullValue\NullValue;

class ToStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns empty string.
     */
    public function testReturnsEmptyString()
    {
        $instance = NullValue::create();
        $value = (string)$instance;

        static::assertSame('', $value);
    }
}
