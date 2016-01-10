<?php
namespace tests\unit\attributes\String\StringLiteral;

use DatabaseInspect\Attributes\String\StringLiteral;

class ToStringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When called will return the stored string value.
     */
    public function testWhenCalledWillReturnTheStoredStringValue()
    {
        $value = 'AAA123';
        $instance = new StringLiteral($value);

        $returnedValue = (string)$instance;
        static::assertSame($value, $returnedValue);
    }
}
