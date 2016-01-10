<?php
namespace tests\unit\lib\Infrastructure\Services\SchemaService;

use DatabaseInspect\Infrastructure\Services\SchemaService;
use DatabaseInspect\Persistence\Repositories\SchemaRepository;

class ConstructTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Will store input repository.
     */
    public function testWillStoreInputRepository()
    {
        $repository = \Mockery::mock(SchemaRepository::class);
        $instance = new SchemaService($repository);

        $helper = \ClassHelper::instance($instance);
        static::assertSame($repository, $helper->repository);
    }
}
