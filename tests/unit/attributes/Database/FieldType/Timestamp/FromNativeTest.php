<?php
namespace tests\unit\attributes\Database\FieldType\Timestamp;

use DatabaseInspect\Attributes\Database\FieldType;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Throws a BadMethodCallException because no native is allowed for this type.
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Cannot create a Timestamp object via this method.
     */
    public function testThrowsABadMethodCallExceptionBecauseNoNativeIsAllowedForThisType()
    {
        FieldType\Timestamp::fromNative();
    }
}
