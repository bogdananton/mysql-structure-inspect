<?php
namespace tests\unit\attributes\Database\FieldDefaultValue;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use tests\TestHelper;

class FromNativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When a scalar or null value is given then build object and store set value.
     *
     * @dataProvider dataProviderScalarValues
     * @param mixed $value
     */
    public function testWhenAScalarOrNullValueIsGivenThenBuildObjectAndStoreSetValue($value)
    {
        $instance = FieldDefaultValue::fromNative($value);
        TestHelper::assertValueObjectHasValue($instance, $value);
    }

    /**
     * When a non-scalar value is given then throw exception.
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage is invalid. Allowed types are "string, int, bool, null".
     *
     * @dataProvider dataProviderNonScalarValues
     * @param mixed $value
     */
    public function testWhenANonScalarValueIsGivenThenThrowException($value)
    {
        FieldDefaultValue::fromNative($value);
    }

    public function dataProviderScalarValues()
    {
        return [
            [10],
            ['A1'],
            [false],
            [null]
        ];
    }

    public function dataProviderNonScalarValues()
    {
        return [
            [['123']],
            [new \stdClass()]
        ];
    }
}
