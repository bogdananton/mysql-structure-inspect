<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use DatabaseInspect\Attributes\Database\IndexType;
use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Domain\Models\TableIndexCollection;

class BuildTableIndexCollectionFromPersistenceTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When an empty array of field is given then return an empty collection.
     */
    public function testWhenAnEmptyArrayOfIndexIsGivenThenReturnAnEmptyCollection()
    {
        $mapper = new SchemaMapper();
        $response = $mapper->buildTableIndexCollectionFromPersistence([]);

        static::assertEquals([], $response->toArray());
    }

    /**
     * When fields are given then pass them to the build collection method.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWhenIndexsAreGivenThenPassThemToTheBuildCollectionMethod()
    {
        /** @var \Mockery\MockInterface|SchemaMapper $mapper */
        $mapper = \Mockery::mock(SchemaMapper::class)->makePartial();

        $getTable0 = 'getTable0';
        $getNonUnique0 = 'getNonUnique0';
        $getKeyName0 = 'getKeyName0';
        $getSeqInIndex0 = 'getSeqInIndex0';
        $getColumnName0 = 'getColumnName0';
        $getCollation0 = 'getCollation0';
        $getCardinality0 = 'getCardinality0';
        $getSubPart0 = 'getSubPart0';
        $getPacked0 = 'getPacked0';
        $getIsNull0 = 'getIsNull0';
        $getIndexType0 = 'getIndexType0';
        $getComment0 = 'getComment0';
        $getIndexComment0 = 'getIndexComment0';

        $getTable1 = 'getTable1';
        $getNonUnique1 = 'getNonUnique1';
        $getKeyName1 = 'getKeyName1';
        $getSeqInIndex1 = 'getSeqInIndex1';
        $getColumnName1 = 'getColumnName1';
        $getCollation1 = 'getCollation1';
        $getCardinality1 = 'getCardinality1';
        $getSubPart1 = 'getSubPart1';
        $getPacked1 = 'getPacked1';
        $getIsNull1 = 'getIsNull1';
        $getIndexType1 = 'getIndexType1';
        $getComment1 = 'getComment1';
        $getIndexComment1 = 'getIndexComment1';

        $persistenceIndex0 = \Mockery::mock(TableIndex::class)->makePartial();
        $persistenceIndex0->shouldReceive('getTable')->once()->andReturn($getTable0);
        $persistenceIndex0->shouldReceive('getNonUnique')->once()->andReturn($getNonUnique0);
        $persistenceIndex0->shouldReceive('getKeyName')->once()->andReturn($getKeyName0);
        $persistenceIndex0->shouldReceive('getSeqInIndex')->once()->andReturn($getSeqInIndex0);
        $persistenceIndex0->shouldReceive('getColumnName')->once()->andReturn($getColumnName0);
        $persistenceIndex0->shouldReceive('getCollation')->once()->andReturn($getCollation0);
        $persistenceIndex0->shouldReceive('getCardinality')->once()->andReturn($getCardinality0);
        $persistenceIndex0->shouldReceive('getSubPart')->once()->andReturn($getSubPart0);
        $persistenceIndex0->shouldReceive('getPacked')->once()->andReturn($getPacked0);
        $persistenceIndex0->shouldReceive('getIsNull')->once()->andReturn($getIsNull0);
        $persistenceIndex0->shouldReceive('getIndexType')->once()->andReturn($getIndexType0);
        $persistenceIndex0->shouldReceive('getComment')->once()->andReturn($getComment0);
        $persistenceIndex0->shouldReceive('getIndexComment')->once()->andReturn($getIndexComment0);

        $persistenceIndex1 = \Mockery::mock(TableIndex::class)->makePartial();
        $persistenceIndex1->shouldReceive('getTable')->once()->andReturn($getTable1);
        $persistenceIndex1->shouldReceive('getNonUnique')->once()->andReturn($getNonUnique1);
        $persistenceIndex1->shouldReceive('getKeyName')->once()->andReturn($getKeyName1);
        $persistenceIndex1->shouldReceive('getSeqInIndex')->once()->andReturn($getSeqInIndex1);
        $persistenceIndex1->shouldReceive('getColumnName')->once()->andReturn($getColumnName1);
        $persistenceIndex1->shouldReceive('getCollation')->once()->andReturn($getCollation1);
        $persistenceIndex1->shouldReceive('getCardinality')->once()->andReturn($getCardinality1);
        $persistenceIndex1->shouldReceive('getSubPart')->once()->andReturn($getSubPart1);
        $persistenceIndex1->shouldReceive('getPacked')->once()->andReturn($getPacked1);
        $persistenceIndex1->shouldReceive('getIsNull')->once()->andReturn($getIsNull1);
        $persistenceIndex1->shouldReceive('getIndexType')->once()->andReturn($getIndexType1);
        $persistenceIndex1->shouldReceive('getComment')->once()->andReturn($getComment1);
        $persistenceIndex1->shouldReceive('getIndexComment')->once()->andReturn($getIndexComment1);

        $domainIndex0 = \Mockery::mock(\DatabaseInspect\Domain\Models\TableIndex::class)->makePartial();
        $domainIndex1 = \Mockery::mock(\DatabaseInspect\Domain\Models\TableIndex::class)->makePartial();

        $mapper->shouldReceive('buildIndex')
            ->once()
            ->with($getTable0, $getNonUnique0, $getKeyName0, $getSeqInIndex0, $getColumnName0, $getCollation0, $getCardinality0, $getSubPart0, $getPacked0, $getIsNull0, $getIndexType0, $getComment0, $getIndexComment0)
            ->andReturn($domainIndex0);

        $mapper->shouldReceive('buildIndex')
            ->once()
            ->with($getTable1, $getNonUnique1, $getKeyName1, $getSeqInIndex1, $getColumnName1, $getCollation1, $getCardinality1, $getSubPart1, $getPacked1, $getIsNull1, $getIndexType1, $getComment1, $getIndexComment1)
            ->andReturn($domainIndex1);

        // overload static build collection
        $request = \Mockery::mock('overload:\DatabaseInspect\Domain\Models\TableIndexCollection');
        $request->shouldReceive('build')
            ->once()
            ->with([$domainIndex0, $domainIndex1])
            ->andReturn(\Mockery::self());

        // perform action
        /** @var TableIndexCollection $output */
        $response = $mapper->buildTableIndexCollectionFromPersistence([
            $persistenceIndex0,
            $persistenceIndex1
        ]);

        // assert expectation
        static::assertInstanceOf(TableIndexCollection::class, $response);
        static::assertSame($request, $response);
    }
}
