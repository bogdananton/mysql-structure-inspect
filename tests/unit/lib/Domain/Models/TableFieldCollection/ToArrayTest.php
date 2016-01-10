<?php
namespace tests\unit\lib\Domain\Models\TableFieldCollection;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\TableField;
use DatabaseInspect\Domain\Models\TableFieldCollection;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When entries are passed at build time then return them as an array.
     */
    public function testWhenEntriesArePassedThenStoreThem()
    {
        $fields = [
            TableField::build(
                StringLiteral::fromNative('id'),
                FieldType::fromNative('int(3)'),
                false,
                FieldKeyType::fromNative('PRI'),
                FieldDefaultValue::fromNative(''),
                StringLiteral::fromNative('')
            ),
            TableField::build(
                StringLiteral::fromNative('name'),
                FieldType::fromNative('varchar(255)'),
                false,
                FieldKeyType::fromNative(''),
                FieldDefaultValue::fromNative(''),
                StringLiteral::fromNative('')
            ),
        ];

        $instance = TableFieldCollection::build($fields);
        $response = $instance->toArray();

        $expected = [
            [
                'name' => 'id',
                'type' => 'int(3)',
                'null' => false,
                'key' => 'PRI',
                'default' => '',
                'extra' => '',
            ],
            [
                'name' => 'name',
                'type' => 'varchar(255)',
                'null' => false,
                'key' => '',
                'default' => '',
                'extra' => '',
            ]
        ];

        static::assertEquals($expected, $response);
    }
}
