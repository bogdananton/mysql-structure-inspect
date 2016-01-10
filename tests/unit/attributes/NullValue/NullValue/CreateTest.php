<?php
namespace tests\unit\attributes\NullValue\NullValue;

use DatabaseInspect\Attributes\NullValue\NullValue;

class CreateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create a new instance of self.
     */
    public function testCreateANewInstanceOfSelf()
    {
        $instance = NullValue::create();
        static::assertInstanceOf(NullValue::class, $instance);
    }
}
