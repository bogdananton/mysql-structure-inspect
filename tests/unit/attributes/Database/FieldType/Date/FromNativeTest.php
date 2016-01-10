<?php
namespace tests\unit\attributes\Database\FieldType\Date;

use DatabaseInspect\Attributes\Database\FieldType;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Throws a BadMethodCallException because no native is allowed for this type.
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Cannot create a Date object via this method.
     */
    public function testThrowsABadMethodCallExceptionBecauseNoNativeIsAllowedForThisType()
    {
        FieldType\Date::fromNative();
    }
}
