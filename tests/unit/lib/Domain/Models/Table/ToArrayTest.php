<?php
namespace tests\unit\lib\Domain\Models\Table;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\Table;
use DatabaseInspect\Domain\Models\TableField;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Domain\Models\TableIndexCollection;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Return entries contents as array.
     */
    public function testReturnEntriesContentsAsArray()
    {
        $instance = self::getInstanceSample();
        $output = $instance->toArray();

        $expected = static::getArraySample();
        static::assertEquals($expected, $output);
    }

    public static function getInstanceSample()
    {
        $name = StringLiteral::fromNative('sample_table_name');

        $fields = TableFieldCollection::build([
            TableField::build(
                StringLiteral::fromNative('sample-name'),
                FieldType::fromNative('varchar(123)'),
                true,
                FieldKeyType::fromNative('sample-key'),
                FieldDefaultValue::fromNative('sample-default'),
                StringLiteral::fromNative('sample-extra')
            )
        ]);

        $indexes = TableIndexCollection::build([
            TableIndex::build(
                new StringLiteral('sample-table'),
                new StringLiteral('sample-nonUnique'),
                new StringLiteral('sample-keyName'),
                new StringLiteral('sample-seqInIndex'),
                new StringLiteral('sample-columnName'),
                new StringLiteral('sample-collation'),
                new StringLiteral('sample-cardinality'),
                new StringLiteral('sample-subPart'),
                new StringLiteral('sample-packed'),
                false,
                new StringLiteral('sample-indexType'),
                new StringLiteral('sample-comment'),
                new StringLiteral('sample-indexComment')
            )
        ]);

        $instance = Table::build($name, $fields, $indexes);

        return $instance;
    }

    public static function getArraySample()
    {
        return [
            "name" => "sample_table_name",
            "fields" => [
                [
                    "name" => "sample-name",
                    "type" => "varchar(123)",
                    "null" => true,
                    "key" => "sample-key",
                    "default" => "sample-default",
                    "extra" => "sample-extra"
                ]
            ],
            "indexes" => [
                [
                    "table" => "sample-table",
                    "nonUnique" => "sample-nonUnique",
                    "keyName" => "sample-keyName",
                    "seqInIndex" => "sample-seqInIndex",
                    "columnName" => "sample-columnName",
                    "collation" => "sample-collation",
                    "cardinality" => "sample-cardinality",
                    "subPart" => "sample-subPart",
                    "packed" => "sample-packed",
                    "isNull" => false,
                    "indexType" => "sample-indexType",
                    "comment" => "sample-comment",
                    "indexComment" => "sample-indexComment"
                ]
            ]
        ];
    }
}
