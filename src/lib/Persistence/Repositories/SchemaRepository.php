<?php
namespace DatabaseInspect\Persistence\Repositories;

use DatabaseInspect\Domain\Mappers\MapperInterface;
use DatabaseInspect\Domain\Models\TableCollection;
use DatabaseInspect\Persistence\Gateways\GatewayInterface;
use DatabaseInspect\Persistence\Models\TableField;
use DatabaseInspect\Persistence\Models\TableIndex;

class SchemaRepository implements RepositoryInterface
{
    /** @var GatewayInterface */
    protected $gateway;

    /** @var MapperInterface */
    protected $mapper;

    public function __construct(GatewayInterface $gateway, MapperInterface $mapper)
    {
        $this->gateway = $gateway;
        $this->mapper = $mapper;
    }

    /**
     * @return TableCollection
     */
    public function getTables()
    {
        $tableNames = $this->gateway->getTableNames();
        $length = count($tableNames);
        $listing = [];

        for ($i = 0; $i < $length; $i++) {
            $table = $this->getTableByName($tableNames[$i]);
            $listing[] = $table;
        }

        $collection = TableCollection::build($listing);
        return $collection;
    }

    protected function getTableByName($tableName)
    {
        /** @var TableField[] $fieldEntries */
        $fieldEntries = $this->gateway->getFieldsByTableName($tableName);

        /** @var TableIndex[] $indexEntries */
        $indexEntries = $this->gateway->getIndexesByTableName($tableName);

        $table = $this->mapper->buildTableFromPersistence($tableName, $fieldEntries, $indexEntries);
        return $table;
    }
}
