<?php
namespace tests\unit\lib\Persistence\Storage\PDOStorage;

use DatabaseInspect\Persistence\Storage\PDOStorage;

class GetTableNamesTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::mock();
    }

    /**
     * Will return table entries.
     * @runInSeparateProcess
     */
    public function testWillReturnTableEntries()
    {
        $expected = [
            'table_0',
            'table_1',
            'table_2',
        ];

        $statement = \Mockery::mock(\PDOStatement::class)->makePartial();
        $statement->shouldReceive('execute')->once();
        $statement->shouldReceive('fetchAll')
            ->once()
            ->andReturn($expected);

        $engine = \Mockery::mock(\PDO::class);
        $engine->shouldReceive('prepare')
            ->once()
            ->with('SHOW TABLES')
            ->andReturn($statement);

        $instance = new PDOStorage($engine);
        $response = $instance->getTableNames();

        static::assertEquals($expected, $response);
    }
}
