<?php
namespace DatabaseInspect\Infrastructure\Services;

use DatabaseInspect\Persistence\Repositories\RepositoryInterface;

class SchemaService
{
    /** @var RepositoryInterface */
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getCompleteSchema()
    {
        $tables = $this->repository->getTables();
        return $tables;
    }
}
