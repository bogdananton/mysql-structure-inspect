<?php
namespace DatabaseInspect\Persistence\Gateways;

use DatabaseInspect\Persistence\DataMappers\DataMapperInterface;
use DatabaseInspect\Persistence\Models\TableField;
use DatabaseInspect\Persistence\Models\TableIndex;
use DatabaseInspect\Persistence\Storage\StorageInterface;

interface GatewayInterface
{
    public function __construct(StorageInterface $storage, DataMapperInterface $mapper);

    /**
     * @return string[]
     */
    public function getTableNames();

    /**
     * @param string $name
     *
     * @return TableField[]
     */
    public function getFieldsByTableName($name);

    /**
     * @param string $name
     *
     * @return TableIndex[]
     */
    public function getIndexesByTableName($name);
}