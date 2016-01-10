<?php
namespace tests\unit\attributes\String\StringLiteral;

use DatabaseInspect\Attributes\String\StringLiteral;

class IsEmptyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When the stored value is an empty string then return true.
     */
    public function testWhenTheStoredValueIsAnEmptyStringThenReturnTrue()
    {
        $stringInstance = new StringLiteral('');

        $result = $stringInstance->isEmpty();
        static::assertTrue($result);
    }

    /**
     * When the stored value is a non-empty string then return false.
     */
    public function testWhenTheStoredValueIsANonEmptyStringThenReturnFalse()
    {
        $stringInstance = new StringLiteral('ten');

        $result = $stringInstance->isEmpty();
        static::assertFalse($result);
    }
}
