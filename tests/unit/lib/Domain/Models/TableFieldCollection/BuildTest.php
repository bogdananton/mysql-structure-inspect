<?php
namespace tests\unit\lib\Domain\Models\TableFieldCollection;

use DatabaseInspect\Domain\Models\TableField;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndex;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When no entries are passed then build empty collection.
     */
    public function testWhenNoEntriesArePassedThenBuildEmptyCollection()
    {
        $response = TableFieldCollection::build();
        $helper = \ClassHelper::instance($response);

        static::assertInstanceOf(TableFieldCollection::class, $response);
        static::assertEquals([], $helper->entries);
    }

    /**
     * When entries are passed then store them.
     */
    public function testWhenEntriesArePassedThenStoreThem()
    {
        $fields = [
            new TableField(),
            new TableField(),
        ];

        $response = TableFieldCollection::build($fields);
        $helper = \ClassHelper::instance($response);

        static::assertEquals($fields, $helper->entries);
    }

    /**
     * When among the entries is a non TableField object then throw exception.
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid field entries.
     */
    public function testWhenAmongTheEntriesIsANonTableFieldObjectThenThrowException()
    {
        $fields = [
            new TableField(),
            new TableIndex(),
        ];

        TableFieldCollection::build($fields);
    }
}
