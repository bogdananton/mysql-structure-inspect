<?php
namespace tests\unit\lib\Domain\Models\TableField;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\TableField;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When isNull has boolean value then build instance.
     *
     * @dataProvider dataProviderBooleanValues
     * @param $bool
     */
    public function testWhenIsNullHasBooleanValueThenBuildInstance($bool)
    {
        $name = 'sample-name';
        $type = 'varchar(123)';
        $key = 'sample-key';
        $isNull = $bool;
        $default = 'sample-default';
        $extra = 'sample-extra';

        $object = TableField::build(
            StringLiteral::fromNative($name),
            FieldType::fromNative($type),
            $isNull,
            FieldKeyType::fromNative($key),
            FieldDefaultValue::fromNative($default),
            StringLiteral::fromNative($extra)
        );

        $expected = [
            'name' => 'sample-name',
            'type' => 'varchar(123)',
            'null' => $bool,
            'key' => 'sample-key',
            'default' => 'sample-default',
            'extra' => 'sample-extra',
        ];

        static::assertInstanceOf(TableField::class, $object);
        static::assertEquals($expected, $object->toArray());
    }

    /**
     * When isNull is not boolean will throw exception.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The isNull argument doesn't have a boolean value.
     */
    public function testWhenIsNullIsNotBooleanWillThrowException()
    {
        $name = 'sample-name';
        $type = 'varchar(123)';
        $key = 'sample-key';
        $default = 'sample-default';
        $extra = 'sample-extra';

        TableField::build(
            StringLiteral::fromNative($name),
            FieldType::fromNative($type),
            'isNull',
            FieldKeyType::fromNative($key),
            FieldDefaultValue::fromNative($default),
            StringLiteral::fromNative($extra)
        );
    }

    public function dataProviderBooleanValues()
    {
        return [
            [true],
            [false],
        ];
    }
}
