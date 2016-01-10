<?php
namespace DatabaseInspect\Console\Command;

    use DatabaseInspect\Domain\Mappers\MapperInterface;
    use DatabaseInspect\Persistence\Gateways\GatewayInterface;
    use DatabaseInspect\Persistence\Repositories\SchemaRepository;
    use DatabaseInspect\Infrastructure\Services\SchemaService;
    use DatabaseInspect\Persistence\Storage\StorageInterface;
    use IoC\Container;
    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

class DetailsCommand extends Command
{
    /** @var Container */
    protected $container;

    /**
     * DetailsCommand constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $mapper = $this->getMapper();
        $credentialsInline = $input->getArgument('credentials');
        $credentialsModel = $mapper->buildCredentialsFromInlineFormat($credentialsInline);

        $storage = $this->getStorage($credentialsModel);
        $gateway = $this->getGateway($storage);
        $service = $this->getSchemaService($gateway, $mapper);

        try {
            $response = $service->getCompleteSchema();

            // @todo Add argument to export to a given file or print
            $filename = 'structure-' . date('Ymdhis') . '.json';
            $contents = json_encode($response, JSON_PRETTY_PRINT);
            file_put_contents($filename, $contents);

            $output->writeln('Done. Check out ' . $filename);

        } catch (\Exception $e) {
            $message = $e->getFile() . ' (' . $e->getLine() . ')' . $e->getTraceAsString();
            $output->writeln($message);
            return -1;
        }
    }

    protected function configure()
    {
        $this->setName('details')
            ->setDescription('List database details.')
            ->addArgument('credentials', InputArgument::REQUIRED, 'Credentials in the following format: user:password@host/database');
    }

    protected function getMapper()
    {
        return $this->container->resolve('Domain\Mapper\Schema');
    }

    /**
     * @param $credentialsModel
     *
     * @return object
     * @throws \Exception
     */
    protected function getStorage($credentialsModel)
    {
        return $this->container->resolve('Persistence\Storage\PDO', [$credentialsModel]);
    }

    /**
     * @param $storage
     *
     * @return object
     * @throws \Exception
     */
    protected function getGateway($storage)
    {
        return $this->container->resolve('Persistence\Gateway\Schema\MySQL', [$storage]);
    }

    /**
     * @param $gateway
     * @param $mapper
     *
     * @return SchemaService
     */
    protected function getSchemaService($gateway, $mapper)
    {
        return $this->container->resolve('Infrastructure\Services\Schema', [$gateway, $mapper]);
    }
}
