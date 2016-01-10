<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use Mockery;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndexCollection;
use DatabaseInspect\Persistence\Models\TableField;
use DatabaseInspect\Persistence\Models\TableIndex;

class BuildTableFromPersistenceTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Will return a table model after converting index and field models from persistence to domain.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWillReturnATableModelAfterConvertingIndexAndFieldModelsFromPersistenceToDomain()
    {
        /** @var \Mockery\MockInterface|SchemaMapper $mapper */
        $mapper = \Mockery::mock('\DatabaseInspect\Domain\Mappers\SchemaMapper')->makePartial();

        // define input
        $tableName = 'table_1';

        $fieldEntries = [
            \Mockery::mock(TableField::class),
            \Mockery::mock(TableField::class),
            \Mockery::mock(TableField::class),
        ];

        $indexEntries = [
            \Mockery::mock(TableIndex::class),
            \Mockery::mock(TableIndex::class)
        ];

        // define internal DTO -> Domain model translators
        $indexCollection = \Mockery::mock(TableIndexCollection::class);
        $fieldCollection = \Mockery::mock(TableFieldCollection::class);

        $mapper->shouldReceive('buildTableFieldCollectionFromPersistence')
            ->once()
            ->with($fieldEntries)
            ->andReturn($fieldCollection);

        $mapper->shouldReceive('buildTableIndexCollectionFromPersistence')
            ->once()
            ->with($indexEntries)
            ->andReturn($indexCollection);

        // define static Table build asserts and expectation
        $buildOutput = \Mockery::mock(Table::class);

        $closureCheckTableNamePassedToTableBuild = \Mockery::on(function (StringLiteral $tableName) {
            return $tableName->toNative() === 'table_1';
        });

        $request = \Mockery::mock('overload:DatabaseInspect\Domain\Models\Table');
        $request->shouldReceive('build')->once()
            ->with($closureCheckTableNamePassedToTableBuild, $fieldCollection, $indexCollection)
            ->andReturn($buildOutput);

        // perform action
        /** @var Table $output */
        $response = $mapper->buildTableFromPersistence($tableName, $fieldEntries, $indexEntries);

        // assert expectation
        static::assertSame($buildOutput, $response);
    }
}
