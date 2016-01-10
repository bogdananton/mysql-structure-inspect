<?php
namespace tests\unit\lib\Domain\Models\TableIndex;

use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\TableIndex;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Store input fields values.
     */
    public function testStoreInputFieldsValues()
    {
        $table = new StringLiteral('sample-table');
        $nonUnique = new StringLiteral('sample-nonUnique');
        $keyName = new StringLiteral('sample-keyName');
        $seqInIndex = new StringLiteral('sample-seqInIndex');
        $columnName = new StringLiteral('sample-columnName');
        $collation = new StringLiteral('sample-collation');
        $cardinality = new StringLiteral('sample-cardinality');
        $subPart = new StringLiteral('sample-subPart');
        $packed = new StringLiteral('sample-packed');
        $isNull = true;
        $indexType = new StringLiteral('sample-indexType');
        $comment = new StringLiteral('sample-comment');
        $indexComment = new StringLiteral('sample-indexComment');

        $response = TableIndex::build(
            $table,
            $nonUnique,
            $keyName,
            $seqInIndex,
            $columnName,
            $collation,
            $cardinality,
            $subPart,
            $packed,
            $isNull,
            $indexType,
            $comment,
            $indexComment
        );

        // assert output type
        static::assertInstanceOf(TableIndex::class, $response);
        $helper = \ClassHelper::instance($response);

        // check stored values
        static::assertSame($table, $helper->table);
        static::assertSame($nonUnique, $helper->nonUnique);
        static::assertSame($keyName, $helper->keyName);
        static::assertSame($seqInIndex, $helper->seqInIndex);
        static::assertSame($columnName, $helper->columnName);
        static::assertSame($collation, $helper->collation);
        static::assertSame($cardinality, $helper->cardinality);
        static::assertSame($subPart, $helper->subPart);
        static::assertSame($packed, $helper->packed);
        static::assertSame($isNull, $helper->isNull);
        static::assertSame($indexType, $helper->indexType);
        static::assertSame($comment, $helper->comment);
        static::assertSame($indexComment, $helper->indexComment);

        // check output toArray
        $expected = [
            'table' => 'sample-table',
            'nonUnique' => 'sample-nonUnique',
            'keyName' => 'sample-keyName',
            'seqInIndex' => 'sample-seqInIndex',
            'columnName' => 'sample-columnName',
            'collation' => 'sample-collation',
            'cardinality' => 'sample-cardinality',
            'subPart' => 'sample-subPart',
            'packed' => 'sample-packed',
            'isNull' => true,
            'indexType' => 'sample-indexType',
            'comment' => 'sample-comment',
            'indexComment' => 'sample-indexComment',
        ];
        static::assertEquals($expected, $response->toArray());
    }

    /**
     * When the isNull parameter is not boolean then throw exception.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The isNull argument doesn't have a boolean value.
     */
    public function testWhenTheIsNullParameterIsNotBooleanThenThrowException()
    {
        $table = new StringLiteral('sample-table');
        $nonUnique = new StringLiteral('sample-nonUnique');
        $keyName = new StringLiteral('sample-keyName');
        $seqInIndex = new StringLiteral('sample-seqInIndex');
        $columnName = new StringLiteral('sample-columnName');
        $collation = new StringLiteral('sample-collation');
        $cardinality = new StringLiteral('sample-cardinality');
        $subPart = new StringLiteral('sample-subPart');
        $packed = new StringLiteral('sample-packed');
        $isNull = 'notbool';
        $indexType = new StringLiteral('sample-indexType');
        $comment = new StringLiteral('sample-comment');
        $indexComment = new StringLiteral('sample-indexComment');

        TableIndex::build(
            $table,
            $nonUnique,
            $keyName,
            $seqInIndex,
            $columnName,
            $collation,
            $cardinality,
            $subPart,
            $packed,
            $isNull,
            $indexType,
            $comment,
            $indexComment
        );
    }
}
