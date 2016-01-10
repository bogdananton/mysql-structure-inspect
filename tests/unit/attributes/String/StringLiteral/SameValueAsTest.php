<?php
namespace tests\unit\attributes\String\StringLiteral;

use DatabaseInspect\Attributes\NullValue\NullValue;
use DatabaseInspect\Attributes\String\StringLiteral;

class SameValueAsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When the input isn't of the same class then return false.
     */
    public function testWhenTheInputIsnTOfTheSameClassThenReturnFalse()
    {
        $nullInstance = new NullValue();
        $stringInstance = new StringLiteral('');

        $result = $stringInstance->sameValueAs($nullInstance);
        static::assertFalse($result);
    }

    /**
     * When the input is of the same class but with different native value then return false.
     */
    public function testWhenTheInputIsOfTheSameClassButWithDifferentNativeValueThenReturnFalse()
    {
        $stringInstanceOne = new StringLiteral('instanceOne');
        $stringInstanceTwo = new StringLiteral('instanceTwo');

        $result = $stringInstanceOne->sameValueAs($stringInstanceTwo);
        static::assertFalse($result);
    }

    /**
     * When the input is of the same class and has the same native value then return true.
     */
    public function testWhenTheInputIsOfTheSameClassAndHasTheSameNativeValueThenReturnTrue()
    {
        $stringInstanceOne = new StringLiteral('instanceWithSameValue');
        $stringInstanceTwo = new StringLiteral('instanceWithSameValue');

        $result = $stringInstanceOne->sameValueAs($stringInstanceTwo);
        static::assertTrue($result);
    }
}
