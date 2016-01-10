<?php
namespace tests\unit\attributes\NullValue\NullValue;

use DatabaseInspect\Attributes\NullValue\NullValue;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Will throw exception because the method should not be called directly.
     *
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Cannot create a NullValue object via this method.
     */
    public function testWillThrowExceptionBecauseTheMethodShouldNotBeCalledDirectly()
    {
        NullValue::fromNative();
    }
}
