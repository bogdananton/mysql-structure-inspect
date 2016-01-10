<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use DatabaseInspect\Domain\Models\TableFieldCollection;
use Mockery;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Persistence\Models\TableField;

class BuildTableFieldCollectionFromPersistenceTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * When an empty array of field is given then return an empty collection.
     */
    public function testWhenAnEmptyArrayOfFieldIsGivenThenReturnAnEmptyCollection()
    {
        $mapper = new SchemaMapper();
        $response = $mapper->buildTableFieldCollectionFromPersistence([]);

        static::assertEquals([], $response->toArray());
    }

    /**
     * When fields are given then pass them to the build collection method.
     *
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWhenFieldsAreGivenThenPassThemToTheBuildCollectionMethod()
    {
        /** @var \Mockery\MockInterface|SchemaMapper $mapper */
        $mapper = Mockery::mock(SchemaMapper::class)->makePartial();

        $name0 = 'name0';
        $type0 = 'type0';
        $null0 = 'null0';
        $key0 = 'key0';
        $default0 = 'default0';
        $extra0 = 'extra0';

        $name1 = 'name1';
        $type1 = 'type1';
        $null1 = 'null1';
        $key1 = 'key1';
        $default1 = 'default1';
        $extra1 = 'extra1';

        $persistenceField0 = Mockery::mock(TableField::class)->makePartial();
        $persistenceField0->shouldReceive('getName')->once()->andReturn($name0);
        $persistenceField0->shouldReceive('getType')->once()->andReturn($type0);
        $persistenceField0->shouldReceive('getIsNull')->once()->andReturn($null0);
        $persistenceField0->shouldReceive('getKey')->once()->andReturn($key0);
        $persistenceField0->shouldReceive('getDefault')->once()->andReturn($default0);
        $persistenceField0->shouldReceive('getExtra')->once()->andReturn($extra0);

        $persistenceField1 = Mockery::mock(TableField::class)->makePartial();
        $persistenceField1->shouldReceive('getName')->once()->andReturn($name1);
        $persistenceField1->shouldReceive('getType')->once()->andReturn($type1);
        $persistenceField1->shouldReceive('getIsNull')->once()->andReturn($null1);
        $persistenceField1->shouldReceive('getKey')->once()->andReturn($key1);
        $persistenceField1->shouldReceive('getDefault')->once()->andReturn($default1);
        $persistenceField1->shouldReceive('getExtra')->once()->andReturn($extra1);

        $domainField0 = Mockery::mock(\DatabaseInspect\Domain\Models\TableField::class)->makePartial();
        $domainField1 = Mockery::mock(\DatabaseInspect\Domain\Models\TableField::class)->makePartial();

        $mapper->shouldReceive('buildField')
            ->once()
            ->with($name0, $type0, $null0, $key0, $default0, $extra0)
            ->andReturn($domainField0);

        $mapper->shouldReceive('buildField')
            ->once()
            ->with($name1, $type1, $null1, $key1, $default1, $extra1)
            ->andReturn($domainField1);

        // overload static build collection
        $request = \Mockery::mock('overload:\DatabaseInspect\Domain\Models\TableFieldCollection');
        $request->shouldReceive('build')
            ->once()
            ->with([$domainField0, $domainField1])
            ->andReturn(\Mockery::self());

        // perform action
        /** @var TableFieldCollection $output */
        $response = $mapper->buildTableFieldCollectionFromPersistence([
            $persistenceField0,
            $persistenceField1
        ]);

        // assert expectation
        static::assertInstanceOf(TableFieldCollection::class, $response);
        static::assertSame($request, $response);
    }
}
