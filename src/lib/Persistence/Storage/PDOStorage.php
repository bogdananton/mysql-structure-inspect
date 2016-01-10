<?php
namespace DatabaseInspect\Persistence\Storage;

class PDOStorage implements StorageInterface
{
    protected $engine;

    public function __construct(\PDO $engine)
    {
        $this->engine = $engine;
    }

    public function getTableNames()
    {
        $statement = $this->engine->prepare('SHOW TABLES');
        $statement->execute();
        $response = $statement->fetchAll();

        return $response;
    }

    public function getFieldsByTableName($name)
    {
        $statement = $this->engine->prepare('DESCRIBE ' . $name);
        $statement->execute();
        $entries = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $entries;
    }

    public function getIndexesByTableName($name)
    {
        $statement = $this->engine->prepare('SHOW INDEXES FROM ' . $name);
        $statement->execute();
        $entries = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $entries;
    }
}
