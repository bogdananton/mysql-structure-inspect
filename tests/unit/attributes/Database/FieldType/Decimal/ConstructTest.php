<?php
namespace tests\unit\attributes\Database\FieldType\Decimal;

use DatabaseInspect\Attributes\Database\FieldType;
use tests\TestHelper;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When the arguments are integers then build the object.
     */
    public function testWhenTheArgumentsAreIntegersThenBuildTheObject()
    {
        $instance = new FieldType\Decimal(10, 7);

        TestHelper::assertValueObjectHasValue($instance, 10, 'digits');
        TestHelper::assertValueObjectHasValue($instance, 7, 'decimals');
    }

    /**
     * When at least one of the arguments is not integer then throw exception.
     *
     * @dataProvider dataProviderNotBothNumbersIntegers
     *
     * @expectedException \DatabaseInspect\Attributes\Exceptions\InvalidNativeArgumentException
     * @expectedExceptionMessage is invalid. Allowed types are "int".
     *
     * @param $digits
     * @param $decimals
     */
    public function testWhenAtLeastOneOfTheArgumentsIsNotIntegerThenThrowException($digits, $decimals)
    {
        new FieldType\Decimal($digits, $decimals);
    }

    public function dataProviderNotBothNumbersIntegers()
    {
        return [
            [10, '7'],
            ['10', 7],
            [10, [2]],
            [10, 'a'],
            [new \stdClass(), 1]
        ];
    }
}
