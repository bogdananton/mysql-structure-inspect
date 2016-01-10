<?php
date_default_timezone_set('UTC');
set_time_limit(0);

include_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Input\InputArgument;
use DatabaseInspect\Infrastructure\Services\SchemaService;
use DatabaseInspect\Persistence\Storage\PDOStorage;
use DatabaseInspect\Persistence\DataMappers\SchemaDataMapper;
use DatabaseInspect\Persistence\Gateways\MySQLGateway;
use DatabaseInspect\Persistence\Storage\StorageInterface;
use DatabaseInspect\Persistence\DataMappers\DataMapperInterface;
use DatabaseInspect\Persistence\Gateways\GatewayInterface;
use DatabaseInspect\Persistence\Repositories\SchemaRepository;
use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Mappers\MapperInterface;
use DatabaseInspect\Domain\Models\CredentialsInterface;

$container = \IoC\Container::getInstance('default');

$container->register('Persistence\Storage\PDO', function (CredentialsInterface $credentials) {
    $dsn = 'mysql:host=' . $credentials->getHost() . ';dbname=' . $credentials->getDatabase();
    $pdo = new \PDO($dsn, $credentials->getUsername(), $credentials->getPassword());
    $storage = new PDOStorage($pdo);
    return $storage;
});

$container->register('Persistence\Gateway\Schema\MySQL', function (StorageInterface $storage) use ($container) {
    /** @var DataMapperInterface $dataMapper */
    $dataMapper = $container->resolve('Persistence\DataMapper\Schema');
    $gateway = new MySQLGateway($storage, $dataMapper);
    return $gateway;
});

$container->register('Persistence\DataMapper\Schema', function () {
    $dataMapper = new SchemaDataMapper();
    return $dataMapper;
});

$container->register('Domain\Mapper\Schema', function () {
    $dataMapper = new SchemaMapper();
    return $dataMapper;
});

$container->register('Infrastructure\Services\Schema', function (GatewayInterface $gateway, MapperInterface $mapper) {
    $repository = new SchemaRepository($gateway, $mapper);
    $service = new SchemaService($repository);
    return $service;
});

$app = new \Symfony\Component\Console\Application('MySQL Database Inspector', '1.0.0');

// reset
$app->setDefinition(
    new \Symfony\Component\Console\Input\InputDefinition([
        new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
    ])
);

// commands
$app->addCommands([
    new \DatabaseInspect\Console\Command\DetailsCommand($container),
]);

try {
    $app->run();

} catch (\Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL . 'File: ' . $e->getFile() . ' (' . $e->getLine() . ')' . PHP_EOL;
}
