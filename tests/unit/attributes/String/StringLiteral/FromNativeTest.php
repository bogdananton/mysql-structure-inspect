<?php
namespace tests\unit\attributes\String\StringLiteral;

use DatabaseInspect\Attributes\String\StringLiteral;
use tests\TestHelper;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When called will use first argument to create a new instance.
     */
    public function testWhenCalledWillUseFirstArgumentToCreateANewInstance()
    {
        $value = 'AAA123';
        $result = StringLiteral::fromNative($value);

        TestHelper::assertValueObjectHasValue($result, $value);
    }

    /**
     * When an invalid native is supplied then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     */
    public function testWhenAnInvalidNativeIsSuppliedThenThrowException()
    {
        $value = 123;
        StringLiteral::fromNative($value);
    }
}
