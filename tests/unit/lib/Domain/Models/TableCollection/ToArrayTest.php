<?php
namespace tests\unit\lib\Domain\Models\TableCollection;

use DatabaseInspect\Domain\Models\TableCollection;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * When no entries are set then return empty values.
     */
    public function testWhenNoEntriesAreSetThenReturnEmptyValues()
    {
        $response = TableCollection::build();
        static::assertEquals([], $response->toArray());
    }

    /**
     * When entries are set then return them as an array.
     */
    public function testWhenEntriesAreSetThenReturnThemAsAnArray()
    {
        $tableInstance = \tests\unit\lib\Domain\Models\Table\ToArrayTest::getInstanceSample();
        $tableArray = \tests\unit\lib\Domain\Models\Table\ToArrayTest::getArraySample();

        $response = TableCollection::build([
            $tableInstance
        ]);

        $expected = [
            $tableArray
        ];

        static::assertEquals($expected, $response->toArray());
    }
}
