<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Domain\Mappers\SchemaMapper;

class BuildIndexTest extends \PHPUnit_Framework_TestCase
{
    /** @var  SchemaMapper */
    protected $mapper;
    protected $table = 'sample-table';
    protected $nonUnique = 'sample-nonUnique';
    protected $keyName = 'sample-keyName';
    protected $seqInIndex = 'sample-seqInIndex';
    protected $columnName = 'sample-columnName';
    protected $collation = 'sample-collation';
    protected $cardinality = 'sample-cardinality';
    protected $subPart = 'sample-subPart';
    protected $packed = 'sample-packed';
    protected $isNull = true;
    protected $indexType = 'sample-indexType';
    protected $comment = 'sample-comment';
    protected $indexComment = 'sample-indexComment';

    protected $expected;

    public function setUp()
    {
        $this->mapper = new SchemaMapper();

        $this->expected = [
            'table' => $this->table,
            'nonUnique' => $this->nonUnique,
            'keyName' => $this->keyName,
            'seqInIndex' => $this->seqInIndex,
            'columnName' => $this->columnName,
            'collation' => $this->collation,
            'cardinality' => $this->cardinality,
            'subPart' => $this->subPart,
            'packed' => $this->packed,
            'isNull' => $this->isNull,
            'indexType' => $this->indexType,
            'comment' => $this->comment,
            'indexComment' => $this->indexComment,
        ];
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When subpart is null then build with null subpart value.
     */
    public function testWhenSubpartIsNullThenBuildWithNullSubpartValue()
    {
        /** @var TableIndex $response */
        $response = $this->mapper->buildIndex(
            $this->table,
            $this->nonUnique,
            $this->keyName,
            $this->seqInIndex,
            $this->columnName,
            $this->collation,
            $this->cardinality,
            null,
            $this->packed,
            $this->isNull,
            $this->indexType,
            $this->comment,
            $this->indexComment
        );

        $expected = $this->expected;
        $expected['subPart'] = null;

        static::assertEquals($expected, $response->toArray());
    }

    /**
     * When packed is null then build with null packed value.
     */
    public function testWhenPackedIsNullThenBuildWithNullPackedValue()
    {
        /** @var TableIndex $response */
        $response = $this->mapper->buildIndex(
            $this->table,
            $this->nonUnique,
            $this->keyName,
            $this->seqInIndex,
            $this->columnName,
            $this->collation,
            $this->cardinality,
            $this->subPart,
            null,
            $this->isNull,
            $this->indexType,
            $this->comment,
            $this->indexComment
        );

        $expected = $this->expected;
        $expected['packed'] = null;

        static::assertEquals($expected, $response->toArray());
    }

    /**
     * When isNull is false build with null false.
     */
    public function testWhenIsNullIsFalseBuildWithNullFalse()
    {
        /** @var TableIndex $response */
        $response = $this->mapper->buildIndex(
            $this->table,
            $this->nonUnique,
            $this->keyName,
            $this->seqInIndex,
            $this->columnName,
            $this->collation,
            $this->cardinality,
            $this->subPart,
            $this->packed,
            false,
            $this->indexType,
            $this->comment,
            $this->indexComment
        );

        $expected = $this->expected;
        $expected['isNull'] = false;

        static::assertEquals($expected, $response->toArray());
    }
}
