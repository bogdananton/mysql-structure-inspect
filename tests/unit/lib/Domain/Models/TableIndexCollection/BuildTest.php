<?php
namespace tests\unit\lib\Domain\Models\TableIndexCollection;

use DatabaseInspect\Domain\Models\TableField;
use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Domain\Models\TableIndexCollection;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When an empty list is sent then store empty values and return instance.
     */
    public function testWhenAnEmptyListIsSentThenStoreEmptyValuesAndReturnInstance()
    {
        $response = TableIndexCollection::build([]);
        static::assertInstanceOf(TableIndexCollection::class, $response);

        $helper = \ClassHelper::instance($response);
        static::assertEquals([], $helper->entries);
    }

    /**
     * When fields are instances of TableIndex then store the entries and return the instance.
     */
    public function testWhenFieldsAreInstancesOfTableIndexThenStoreTheEntriesAndReturnTheInstance()
    {
        $input = [
            new TableIndex(),
            new TableIndex(),
            new TableIndex(),
        ];

        $response = TableIndexCollection::build($input);
        static::assertInstanceOf(TableIndexCollection::class, $response);

        $helper = \ClassHelper::instance($response);
        static::assertEquals($input, $helper->entries);
    }

    /**
     * When fields are not instance of tableindex then throw exception.
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid index entries.
     */
    public function testWhenFieldsAreNotInstanceOfTableindexThenThrowException()
    {
        $input = [
            new TableIndex(),
            new TableIndex(),
            new TableField(),
        ];

        TableIndexCollection::build($input);
    }
}
