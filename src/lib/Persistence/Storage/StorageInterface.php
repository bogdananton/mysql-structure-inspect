<?php
namespace DatabaseInspect\Persistence\Storage;

interface StorageInterface
{
    /**
     * @return string[]
     */
    public function getTableNames();

    /**
     * @param $name
     *
     * @return string[][]
     */
    public function getFieldsByTableName($name);

    public function getIndexesByTableName($name);
}
