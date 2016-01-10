<?php
namespace tests\unit\lib\Domain\Models\TableIndexCollection;

use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Domain\Models\TableIndexCollection;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When no entries are set then return empty array.
     */
    public function testWhenNoEntriesAreSetThenReturnEmptyArray()
    {
        $response = TableIndexCollection::build([]);
        $output = $response->toArray();

        static::assertEquals([], $output);
    }

    /**
     * When entries are set then return their array representation.
     */
    public function testWhenEntriesAreSetThenReturnTheirArrayRepresentation()
    {
        $index0 = TableIndex::build(
            new StringLiteral('sample-0-table'),
            new StringLiteral('sample-0-nonUnique'),
            new StringLiteral('sample-0-keyName'),
            new StringLiteral('sample-0-seqInIndex'),
            new StringLiteral('sample-0-columnName'),
            new StringLiteral('sample-0-collation'),
            new StringLiteral('sample-0-cardinality'),
            new StringLiteral('sample-0-subPart'),
            new StringLiteral('sample-0-packed'),
            true,
            new StringLiteral('sample-0-indexType'),
            new StringLiteral('sample-0-comment'),
            new StringLiteral('sample-0-indexComment')
        );

        $index1 = TableIndex::build(
            new StringLiteral('sample-1-table'),
            new StringLiteral('sample-1-nonUnique'),
            new StringLiteral('sample-1-keyName'),
            new StringLiteral('sample-1-seqInIndex'),
            new StringLiteral('sample-1-columnName'),
            new StringLiteral('sample-1-collation'),
            new StringLiteral('sample-1-cardinality'),
            new StringLiteral('sample-1-subPart'),
            new StringLiteral('sample-1-packed'),
            false,
            new StringLiteral('sample-1-indexType'),
            new StringLiteral('sample-1-comment'),
            new StringLiteral('sample-1-indexComment')
        );

        $input = [
            $index0,
            $index1,
        ];

        $instance = TableIndexCollection::build($input);
        $output = $instance->toArray();

        $expected = [
            [
                'table' => 'sample-0-table',
                'nonUnique' => 'sample-0-nonUnique',
                'keyName' => 'sample-0-keyName',
                'seqInIndex' => 'sample-0-seqInIndex',
                'columnName' => 'sample-0-columnName',
                'collation' => 'sample-0-collation',
                'cardinality' => 'sample-0-cardinality',
                'subPart' => 'sample-0-subPart',
                'packed' => 'sample-0-packed',
                'isNull' => true,
                'indexType' => 'sample-0-indexType',
                'comment' => 'sample-0-comment',
                'indexComment' => 'sample-0-indexComment',
            ],
            [
                'table' => 'sample-1-table',
                'nonUnique' => 'sample-1-nonUnique',
                'keyName' => 'sample-1-keyName',
                'seqInIndex' => 'sample-1-seqInIndex',
                'columnName' => 'sample-1-columnName',
                'collation' => 'sample-1-collation',
                'cardinality' => 'sample-1-cardinality',
                'subPart' => 'sample-1-subPart',
                'packed' => 'sample-1-packed',
                'isNull' => false,
                'indexType' => 'sample-1-indexType',
                'comment' => 'sample-1-comment',
                'indexComment' => 'sample-1-indexComment',
            ]
        ];

        static::assertEquals($expected, $output);
    }
}
