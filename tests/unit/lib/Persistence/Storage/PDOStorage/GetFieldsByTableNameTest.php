<?php
namespace tests\unit\lib\Persistence\Storage\PDOStorage;

use DatabaseInspect\Persistence\Storage\PDOStorage;

class GetFieldsByTableNameTest extends \PHPUnit_Framework_TestCase
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
            'field1-response-something'
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
            ->with('DESCRIBE ' . $tableName)
            ->andReturn($statement);

        $instance = new PDOStorage($engine);
        $response = $instance->getFieldsByTableName($tableName);

        static::assertSame($expected, $response);
    }
}
