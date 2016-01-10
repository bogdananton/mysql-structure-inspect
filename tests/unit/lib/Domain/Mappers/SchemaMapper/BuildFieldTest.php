<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Models\TableField;

class BuildFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Build field using input values.
     * @dataProvider dataProviderBooleanValues
     * @param boolean $bool
     */
    public function testBuildFieldUsingInputValues($bool)
    {
        $name = 'sample-name';
        $type = 'varchar(123)';
        $key = 'sample-key';
        $isNull = $bool;
        $default = 'sample-default';
        $extra = 'sample-extra';

        $mapper = new SchemaMapper();
        $response = $mapper->buildField($name, $type, $isNull, $key, $default, $extra);

        $expected = [
            'name' => 'sample-name',
            'type' => 'varchar(123)',
            'null' => $bool,
            'key' => 'sample-key',
            'default' => 'sample-default',
            'extra' => 'sample-extra',
        ];

        static::assertInstanceOf(TableField::class, $response);
        static::assertEquals($expected, $response->toArray());
    }

    public function dataProviderBooleanValues()
    {
        return [
            [true],
            [false],
        ];
    }
}
