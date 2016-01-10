<?php
namespace tests\unit\lib\Domain\Models\TableCollection;

use DatabaseInspect\Domain\Models\Table;
use DatabaseInspect\Domain\Models\TableCollection;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When no entries are passed then return instance with empty entries.
     */
    public function testWhenNoEntriesArePassedThenReturnInstanceWithEmptyEntries()
    {
        $response = TableCollection::build();
        static::assertInstanceOf(TableCollection::class, $response);

        $helper = \ClassHelper::instance($response);
        static::assertEquals([], $helper->entries);
    }

    /**
     * When one of the entries are not a Table then throw exception.
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid Table entries.
     */
    public function testWhenOneOfTheEntriesAreNotATableThenThrowException()
    {
        $input = [
            new \stdClass()
        ];

        TableCollection::build($input);
    }

    /**
     * When table entries are passed then store them.
     */
    public function testWhenTableEntriesArePassedThenStoreThem()
    {
        $input = [
            \Mockery::mock(Table::class),
            \Mockery::mock(Table::class),
        ];

        $instance = TableCollection::build($input);

        $helper = \ClassHelper::instance($instance);
        static::assertSame($input, $helper->entries);
    }
}
