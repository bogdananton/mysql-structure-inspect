<?php
namespace DatabaseInspect\Persistence\Repositories;

use DatabaseInspect\Domain\Mappers\MapperInterface;
use DatabaseInspect\Domain\Models\TableCollection;
use DatabaseInspect\Persistence\Gateways\GatewayInterface;

interface RepositoryInterface
{
    public function __construct(GatewayInterface $gateway, MapperInterface $mapper);

    /**
     * @return TableCollection
     */
    public function getTables();
}
