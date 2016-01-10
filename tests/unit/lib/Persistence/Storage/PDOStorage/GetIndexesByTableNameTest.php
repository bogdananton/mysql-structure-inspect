<?php
namespace tests\unit\lib\Persistence\Storage\PDOStorage;

use DatabaseInspect\Persistence\Storage\PDOStorage;

class GetIndexesByTableNameTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::mock();
    }

    /**
     * Will return entries from table.
     */
    public function testWillReturnEntriesFromTable()
    {
        $tableName = 'table_name';
        $expected = [
            'index1-response-something'
        ];

        $statement = \Mockery::mock(\PDOStatement::class)->makePartial();
        $statement->shouldReceive('execute')->once();
        $statement->shouldReceive('fetchAll')
            ->once()
            ->with(\PDO::FETCH_ASSOC)
            ->andReturn($expected);

        $engine = \Mockery::mock(\PDO::class);
        $engine->shouldReceive('prepare')
            ->once()
            ->with('SHOW INDEXES FROM ' . $tableName)
            ->andReturn($statement);

        $instance = new PDOStorage($engine);
        $response = $instance->getIndexesByTableName($tableName);

        static::assertSame($expected, $response);
    }
}
