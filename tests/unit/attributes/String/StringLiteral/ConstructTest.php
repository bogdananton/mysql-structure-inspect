<?php
namespace tests\unit\attributes\String\StringLiteral;

use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Attributes\ValueObjectInterface;
use tests\TestHelper;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    protected $nonEmptyString = 'ABC1234';

    protected $emptyString = '';

    protected $integerValue = 1234;

    /**
     * When a non-empty string is given then build object.
     *
     * @return StringLiteral
     */
    public function testWhenANonEmptyStringIsGivenThenBuildObject()
    {
        $instance = new StringLiteral($this->nonEmptyString);
        static::assertInstanceOf(StringLiteral::class, $instance);

        return $instance;
    }

    /**
     * The non-empty string given is stored as the value object's value.
     *
     * @depends testWhenANonEmptyStringIsGivenThenBuildObject
     *
     * @param ValueObjectInterface $instance
     */
    public function testTheNonEmptyStringGivenIsStoredAsTheValueObjectSValue(ValueObjectInterface $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, $this->nonEmptyString);
    }

    /**
     * When an empty string is given then build object.
     */
    public function testWhenAnEmptyStringIsGivenThenBuildObject()
    {
        $instance = new StringLiteral($this->emptyString);
        static::assertInstanceOf(StringLiteral::class, $instance);
        TestHelper::assertValueObjectHasValue($instance, $this->emptyString);
    }

    /**
     * When an integer is given then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument "1234" is invalid. Allowed types are "string".
     */
    public function testWhenAnIntegerIsGivenThenThrowException()
    {
        new StringLiteral($this->integerValue);
    }

    /**
     * When a null value is given then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument NULL is invalid. Allowed types are "string".
     */
    public function testWhenANullValueIsGivenThenThrowException()
    {
        $value = null;
        new StringLiteral($value);
    }

    /**
     * When an array is given then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument Array is invalid. Allowed types are "string".
     */
    public function testWhenAnArrayIsGivenThenThrowException()
    {
        $value = [
            'a' => 'b'
        ];
        new StringLiteral($value);
    }

    /**
     * When an object is given then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage Argument Object is invalid. Allowed types are "string".
     */
    public function testWhenAnObjectIsGivenThenThrowException()
    {
        $value = new \stdClass();
        new StringLiteral($value);
    }
}
