<?php
namespace DatabaseInspect\Persistence\Gateways;

use DatabaseInspect\Persistence\DataMappers\DataMapperInterface;
use DatabaseInspect\Persistence\Storage\StorageInterface;

class MySQLGateway implements GatewayInterface
{
    protected $mapper;
    protected $gateway;

    public function __construct(StorageInterface $storage, DataMapperInterface $dataMapper)
    {
        $this->storage = $storage;
        $this->mapper = $dataMapper;
    }

    public function getTableNames()
    {
        $entries = $this->storage->getTableNames();

        $response = [];
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            $response[] = $entries[$i][0];
        }

        return $response;
    }

    public function getFieldsByTableName($name)
    {
        $entries = $this->storage->getFieldsByTableName($name);

        $response = [];
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            $entry = $entries[$i];

            $field = $this->mapper->buildField(
                $entry['Field'],
                $entry['Type'],
                $entry['Null'],
                $entry['Key'],
                $entry['Default'],
                $entry['Extra']
            );

            $response[] = $field;
        }

        return $response;
    }

    public function getIndexesByTableName($name)
    {
        $entries = $this->storage->getIndexesByTableName($name);

        $response = [];
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            $entry = $entries[$i];

            $index = $this->mapper->buildIndex(
                $entry['Table'],
                $entry['Non_unique'],
                $entry['Key_name'],
                $entry['Seq_in_index'],
                $entry['Column_name'],
                $entry['Collation'],
                $entry['Cardinality'],
                $entry['Sub_part'],
                $entry['Packed'],
                $entry['Null'],
                $entry['Index_type'],
                $entry['Comment'],
                $entry['Index_comment']
            );

            $response[] = $index;
        }

        return $response;
    }
}