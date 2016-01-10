<?php
namespace tests\integration\lib\Persistence\Repositories\SchemaRepository;

use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Persistence\DataMappers\SchemaDataMapper;
use DatabaseInspect\Persistence\Gateways\MySQLGateway;
use DatabaseInspect\Persistence\Repositories\SchemaRepository;
use DatabaseInspect\Persistence\Storage\PDOStorage;

class GetTableTest extends \PHPUnit_Framework_TestCase
{
    protected $gateway;

    protected $mapper;

    protected $repository;

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Sample
     */
    public function testSample()
    {
        $storage = \Mockery::mock(PDOStorage::class);
        $storage->shouldReceive('getTableNames')
            ->once()
            ->andReturn([
                ["Tables_in_employees" => "employees", "0" => "employees" ],
                ["Tables_in_employees" => "salaries", "0" => "salaries" ],
            ]);

        $storage->shouldReceive('getFieldsByTableName')
            ->once()
            ->with('employees')
            ->andReturn([
                [
                    "Field" => "emp_no",
                    "Type" => "int(11)",
                    "Null" => "NO",
                    "Key" => "",
                    "Default" => null,
                    "Extra" => ""
                ],
                [
                    "Field" => "dept_no",
                    "Type" => "char(4)",
                    "Null" => "NO",
                    "Key" => "",
                    "Default" => null,
                    "Extra" => ""
                ]
            ]);

        $storage->shouldReceive('getFieldsByTableName')
            ->once()
            ->with('salaries')
            ->andReturn([
                [
                    "Field" => "from_date",
                    "Type" => "date",
                    "Null" => "YES",
                    "Key" => "",
                    "Default" => null,
                    "Extra" => ""
                ],
                [
                    "Field" => "to_date",
                    "Type" => "date",
                    "Null" => "YES",
                    "Key" => "",
                    "Default" => null,
                    "Extra" => ""
                ]
            ]);

        $storage->shouldReceive('getIndexesByTableName')
            ->once()
            ->with('employees')
            ->andReturn([
                [
                    "Table" => "employees",
                    "Non_unique" => "0",
                    "Key_name" => "dept_no",
                    "Seq_in_index" => "1",
                    "Column_name" => "dept_no",
                    "Collation" => "A",
                    "Cardinality" => "9",
                    "Sub_part" => null,
                    "Packed" => null,
                    "Null" => "",
                    "Index_type" => "BTREE",
                    "Comment" => "",
                    "Index_comment" => ""
                ]
            ]);

        $storage->shouldReceive('getIndexesByTableName')
            ->once()
            ->with('salaries')
            ->andReturn([]);

        $dataMapper = new SchemaDataMapper();
        $gateway = new MySQLGateway($storage, $dataMapper);
        $mapper = new SchemaMapper();
        $repository = new SchemaRepository($gateway, $mapper);

        $response = $repository->getTables();
        $expected = static::getSnapshotSample();

        static::assertSame($expected, $response->toArray());
    }

    protected static function getSnapshotSample()
    {
        return [
            [
                "name" => "employees",
                "fields" => [
                [
                    "name" => "emp_no",
                        "type" => "int(11)",
                        "null" => false,
                        "key" => "",
                        "default" => null,
                        "extra" => ""
                    ],
                    [
                        "name" => "dept_no",
                        "type" => "char(4)",
                        "null" => false,
                        "key" => "",
                        "default" => null,
                        "extra" => ""
                    ]
                ],
                "indexes" => [
                    [
                        "table" => "employees",
                        "nonUnique" => "0",
                        "keyName" => "dept_no",
                        "seqInIndex" => "1",
                        "columnName" => "dept_no",
                        "collation" => "A",
                        "cardinality" => "9",
                        "subPart" => null,
                        "packed" => null,
                        "isNull" => false,
                        "indexType" => "BTREE",
                        "comment" => "",
                        "indexComment" => ""
                    ]
                ]
            ],
            [
                "name" => "salaries",
                "fields" => [
                    [
                        "name" => "from_date",
                        "type" => "date",
                        "null" => true,
                        "key" => "",
                        "default" => null,
                        "extra" => ""
                    ],
                    [
                        "name" => "to_date",
                        "type" => "date",
                        "null" => true,
                        "key" => "",
                        "default" => null,
                        "extra" => ""
                    ]
                ],
                "indexes" => []
            ]
        ];
    }
}
