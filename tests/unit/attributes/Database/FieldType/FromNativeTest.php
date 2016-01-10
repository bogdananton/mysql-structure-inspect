<?php
namespace tests\unit\attributes\Database\FieldType;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\ValueObjectInterface as VO;
use tests\TestHelper;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When an unexpected value pattern is given then throw exception.
     *
     * @expectedException \DatabaseInspect\Attributes\Exceptions\UnexpectedValueException
     * @expectedExceptionMessage Argument "varchar" is invalid. Expected value patterns are
     */
    public function testWhenAnUnexpectedValuePatternIsGivenThenThrowException()
    {
        $value = 'varchar';
        FieldType::fromNative($value);
    }

    /**
     * When a varchar with length is given then return a Varchar field type.
     */
    public function testWhenAVarcharWithLengthIsGivenThenReturnAVarcharFieldType()
    {
        $value = 'varchar(255)';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Varchar::class, $response);

        return $response;
    }

    /**
     * The varchar will have the value of the given length.
     * @depends testWhenAVarcharWithLengthIsGivenThenReturnAVarcharFieldType
     *
     * @param VO $instance
     */
    public function testTheVarcharWillHaveTheValueOfTheGivenLength(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '255');
    }


    /**
     * When a char with length is given then return a Char field type.
     */
    public function testWhenACharWithLengthIsGivenThenReturnACharFieldType()
    {
        $value = 'char(4)';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Char::class, $response);
        return $response;
    }

    /**
     * The char will have the value of the given length.
     *
     * @depends testWhenACharWithLengthIsGivenThenReturnACharFieldType
     * @param VO $instance
     */
    public function testTheCharWillHaveTheValueOfTheGivenLength(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '4');
    }

    /**
     * When the input is "timestamp" as a string then return a timestamp value object.
     */
    public function testWhenTheInputIsTimestampAsAStringThenReturnATimestampValueObject()
    {
        $value = 'timestamp';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Timestamp::class, $response);
    }

    /**
     * When the input is "datetime" as a string then return a datetime value object.
     */
    public function testWhenTheInputIsDatetimeAsAStringThenReturnADatetimeValueObject()
    {
        $value = 'datetime';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Datetime::class, $response);
    }

    /**
     * When the input is "date" as a string then return a date value object.
     */
    public function testWhenTheInputIsDateAsAStringThenReturnADateValueObject()
    {
        $value = 'date';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Date::class, $response);
    }

    /**
     * When the input is "text" as a string then return a date value object.
     */
    public function testWhenTheInputIsTimeAsAStringThenReturnADateValueObject()
    {
        $value = 'text';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Text::class, $response);
    }

    /**
     * When the input describes an unsigned integer with a length then return an unsigned integer value object.
     * @return VO
     */
    public function testWhenTheInputDescribesAnUnsignedIntegerWithALengthThenReturnAnUnsignedIntegerValueObject()
    {
        $value = 'int(123) unsigned';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\IntUnsigned::class, $response);
        return $response;
    }

    /**
     * The unsigned integer will have the length given in the string definition.
     *
     * @depends testWhenTheInputDescribesAnUnsignedIntegerWithALengthThenReturnAnUnsignedIntegerValueObject
     * @param VO $instance
     */
    public function testTheUnsignedIntegerWillHaveTheLengthGivenInTheStringDefinition(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '123');
    }

    /**
     * When the input describes a signed integer with a length then return a signed integer value object.
     * @return VO
     */
    public function testWhenTheInputDescribesASignedIntegerWithALengthThenReturnASignedIntegerValueObject()
    {
        $value = 'int(321)';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\IntSigned::class, $response);
        return $response;
    }

    /**
     * The signed integer will have the length given in the string definition.
     *
     * @depends testWhenTheInputDescribesASignedIntegerWithALengthThenReturnASignedIntegerValueObject
     * @param VO $instance
     */
    public function testTheSignedIntegerWillHaveTheLengthGivenInTheStringDefinition(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '321');
    }

    /**
     * When the input describes a decimal then return a decimal value object.
     * @return VO
     */
    public function testWhenTheInputDescribesADecimalThenReturnADecimalValueObject()
    {
        $value = 'decimal(10,4)';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Decimal::class, $response);
        return $response;
    }

    /**
     * The decimal value object will have the the digits and decimals as they were set in de definition.
     *
     * @depends testWhenTheInputDescribesADecimalThenReturnADecimalValueObject
     * @param VO $instance
     */
    public function testTheDecimalValueObjectWillHaveTheTheDigitsAndDecimalsAsTheyWereSetInDeDefinition(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, 10, 'digits');
        TestHelper::assertValueObjectHasValue($instance, 4, 'decimals');
    }

    /**
     * When the input describes a tinyint with a length then return a signed tinyint value object.
     * @return VO
     */
    public function testWhenTheInputDescribesATinyintWithALengthThenReturnASignedTinyintValueObject()
    {
        $value = 'tinyint(2)';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\TinyIntSigned::class, $response);
        return $response;
    }

    /**
     * The signed tinyint will have the length given in the string definition.
     *
     * @depends testWhenTheInputDescribesATinyintWithALengthThenReturnASignedTinyintValueObject
     * @param VO $instance
     */
    public function testTheSignedTinyintWillHaveTheLengthGivenInTheStringDefinition(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '2');
    }

    /**
     * When the input describes an enum then return an enum value object.
     */
    public function testWhenTheInputDescribesAnEnumThenReturnAnEnumValueObject()
    {
        $value = 'enum(1,2,3,4,\'5\')';
        $response = FieldType::fromNative($value);

        static::assertInstanceOf(FieldType\Enum::class, $response);
        return $response;
    }

    /**
     * The enum options will be stored as they are given without splitting or processing the values.
     * @depends testWhenTheInputDescribesAnEnumThenReturnAnEnumValueObject
     * @param VO $instance
     */
    public function testTheEnumOptionsWillBeStoredAsTheyAreGivenWithoutSplittingOrProcessingTheValues(VO $instance)
    {
        TestHelper::assertValueObjectHasValue($instance, '1,2,3,4,\'5\'');
    }
}
