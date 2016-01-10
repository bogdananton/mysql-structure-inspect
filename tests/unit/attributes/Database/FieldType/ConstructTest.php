<?php
namespace tests\unit\attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use tests\TestHelper;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When no input is given then store empty value.
     */
    public function testWhenNoValueIsGivenThenStoreEmptyValue()
    {
        $instance = new FieldType();
        TestHelper::assertValueObjectHasValue($instance, '');
    }

    /**
     * When the input is string then store value.
     */
    public function testWhenTheInputIsStringThenStoreValue()
    {
        $instance = new FieldType('abc123');
        TestHelper::assertValueObjectHasValue($instance, 'abc123');
    }

    /**
     * When the input is numeric then store value.
     */
    public function testWhenTheInputIsNumericThenStoreValue()
    {
        $instance = new FieldType(12.3);
        TestHelper::assertValueObjectHasValue($instance, 12.3);
    }

    /**
     * When the input is an array then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument Array is invalid. Allowed types are "string, int, float".
     */
    public function testWhenTheInputIsAnArrayThenThrowException()
    {
        $input = ['123'];
        new FieldType($input);
    }

    /**
     * When the input is an object then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument Object is invalid. Allowed types are "string, int, float".
     */
    public function testWhenTheInputIsAnObjectThenThrowException()
    {
        $input = new \stdClass();
        $input->value = 123;

        new FieldType($input);
    }

    /**
     * When the input is null then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument NULL is invalid. Allowed types are "string, int, float".
     */
    public function testWhenTheInputIsNullThenThrowException()
    {
        $input = null;
        new FieldType($input);
    }
}
