<?php
namespace tests\unit\lib\Domain\Models\Table;

use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\Table;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndexCollection;

class BuildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Store entries.
     */
    public function testStoreEntries()
    {
        $name = StringLiteral::fromNative('sample_table_name');
        $fields = TableFieldCollection::build([]);
        $indexes = TableIndexCollection::build([]);

        $instance = Table::build($name, $fields, $indexes);
        static::assertInstanceOf(Table::class, $instance);

        $helper = \ClassHelper::instance($instance);
        static::assertSame($name, $helper->name);
        static::assertSame($fields, $helper->fields);
        static::assertSame($indexes, $helper->indexes);
    }
}
