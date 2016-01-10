<?php
namespace tests\unit\lib\Infrastructure\Services\SchemaService;

use DatabaseInspect\Domain\Models\TableCollection;
use DatabaseInspect\Infrastructure\Services\SchemaService;
use DatabaseInspect\Persistence\Repositories\SchemaRepository;

class GetCompleteSchemaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns tables from repository.
     */
    public function testReturnsTablesFromRepository()
    {
        $response = \Mockery::mock(TableCollection::class);

        $repository = \Mockery::mock(SchemaRepository::class);
        $repository->shouldReceive('getTables')->once()->andReturn($response);

        $instance = new SchemaService($repository);
        static::assertSame($response, $instance->getCompleteSchema());
    }
}
