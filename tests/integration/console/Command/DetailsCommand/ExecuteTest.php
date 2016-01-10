<?php
namespace tests\integration\console\Command\DetailsCommand;

use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Models\CredentialsInterface;
use DatabaseInspect\Infrastructure\Services\SchemaService;
use DatabaseInspect\Persistence\Gateways\MySQLGateway;
use DatabaseInspect\Persistence\Storage\StorageInterface;
use IoC\Container;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\ConsoleOutput;
use tests\TestHelper;

class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    protected $container;
    protected $command;
    protected $schemaService;
    protected $schemaContentsResponse;
    protected $schemaContentsJsonResponse;
    protected $input;
    protected $output;
    protected $expectedDate;
    protected $expectedFilename;
    protected $expectedSuccessEndMessage;

    public function tearDown()
    {
        TestHelper::$spy = null;
        \Mockery::close();
    }

    /**
     * When there's an exception while running the command then write trace to output and return code.
     * @runInSeparateProcess
     */
    public function testWhenThereSAnExceptionWhileRunningTheCommandThenWriteTraceToOutputAndReturnCode()
    {
        // prepare
        $this->prepare();

        $this->schemaService->shouldReceive('getCompleteSchema')->once()->andThrow(new \Exception());
        $this->output->shouldReceive('writeln')->once()->with(\Mockery::on(function ($message) {
            if (strlen($message) < 1000) {
                \PHPUnit_Framework_TestCase::fail('expected trace, got ' . $message);
            }
            return true;
        }));

        $response = $this->call();

        // scan output
        static::assertEquals(-1, $response);
    }

    /**
     * Write the extracted schema to file.
     * @runInSeparateProcess
     */
    public function testWriteToFileTheExtractedSchema()
    {
        $this->schemaContentsResponse = ['sample' => 'schema-response-dummy'];
        $this->schemaContentsJsonResponse = '{"sample": "schema-response-dummy"}';
        $this->expectedDate = '20160110065235';
        $this->expectedFilename = 'structure-20160110065235.json';
        $this->expectedSuccessEndMessage = 'Done. Check out structure-20160110065235.json';

        // prepare
        $this->prepare();
        // $this->prepareConfiguration();
        $this->prepareInternalFunctionsOverride();

        $this->schemaService->shouldReceive('getCompleteSchema')
            ->once()
            ->andReturn($this->schemaContentsResponse);

        $this->output->shouldReceive('writeln')
            ->once()
            ->with($this->expectedSuccessEndMessage);

        $response = $this->call();

        // scan output
        static::assertNull($response);
    }

    protected function prepareConfiguration()
    {
        $this->command->shouldReceive('setName')
            ->once()
            ->with('details')
            ->andReturn(\Mockery::self());

        $this->command
            ->shouldReceive('setDescription')
            ->once()
            ->with('List database details.')
            ->andReturn(\Mockery::self());

        $this->command
            ->shouldReceive('addArgument')
            ->once()
            ->with(
                'credentials',
                InputArgument::REQUIRED,
                'Credentials in the following format: user:password@host/database'
            )
            ->andReturn(\Mockery::self());
    }

    protected function call()
    {
        $helper = \ClassHelper::instance($this->command);
        $helper->container = $this->container;

        $response = $helper->call('execute', [$this->input, $this->output]);

        return $response;
    }

    protected function prepare()
    {
        $this->container = \Mockery::mock(Container::class)->makePartial();

        $schemaMapper = \Mockery::mock(SchemaMapper::class)->makePartial();
        $schemaMapper->shouldReceive('buildCredentialsFromInlineFormat')->once()->passthru();
        $this->container->shouldReceive('resolve')->once()->with('Domain\Mapper\Schema')->andReturn($schemaMapper);

        $credentialsMatcher = \Mockery::on(function ($args) {
            /** @var CredentialsInterface $credentials */
            $credentials = $args[0];
            \PHPUnit_Framework_TestCase::assertInstanceOf(CredentialsInterface::class, $credentials);

            $actual = $credentials->toArray();

            $expected = [
                "username" => "user1",
                "password" => "pass2",
                "host" => "sample.host",
                "database" => "sample_database",
            ];

            if ($expected != $actual) {
                \PHPUnit_Framework_TestCase::fail('Check credentials format or sample.');
            }

            return true;
        });

        $pdo = \Mockery::mock(\PDO::class);
        $this->container
            ->shouldReceive('resolve')
            ->once()
            ->with('Persistence\Storage\PDO', $credentialsMatcher)
            ->andReturn($pdo);

        $storageMatcher = \Mockery::on(function ($args) use ($pdo) {
            /** @var StorageInterface $storage */
            $storage = $args[0];

            if ($pdo != $storage) {
                \PHPUnit_Framework_TestCase::fail('Check pipes.');
            }

            return true;
        });

        $gateway = \Mockery::mock(MySQLGateway::class);
        $this->container
            ->shouldReceive('resolve')
            ->once()
            ->with('Persistence\Gateway\Schema\MySQL', $storageMatcher)
            ->andReturn($gateway);

        $gatewayAndMapperMatcher = \Mockery::on(function ($args) use ($gateway, $schemaMapper) {
            if ($args[0] != $gateway) {
                \PHPUnit_Framework_TestCase::fail('Gateway mismatch.');
            }
            if ($args[1] != $schemaMapper) {
                \PHPUnit_Framework_TestCase::fail('Mapper mismatch.');
            }
            return true;
        });

        $this->schemaService = \Mockery::mock(SchemaService::class);

        $this->container
            ->shouldReceive('resolve')
            ->once()
            ->with('Infrastructure\Services\Schema', $gatewayAndMapperMatcher)
            ->andReturn($this->schemaService);

        $classCommand = '\DatabaseInspect\Console\Command\DetailsCommand[execute]';
        $this->command = \Mockery::mock($classCommand, [$this->container])->makePartial();

        $this->input = \Mockery::mock(ArgvInput::class);
        $this->input->shouldReceive('getArgument')->once()->andReturn('user1:pass2@sample.host/sample_database');

        $this->output = \Mockery::mock(ConsoleOutput::class);
    }

    protected function prepareInternalFunctionsOverride()
    {
        $spy = \Mockery::mock('Internal');

        $spy->shouldReceive('DatabaseInspect\Console\Command\date')
            ->once()
            ->with('Ymdhis')
            ->andReturn($this->expectedDate);

        $spy->shouldReceive('DatabaseInspect\Console\Command\json_encode')
            ->once()
            ->with($this->schemaContentsResponse, JSON_PRETTY_PRINT)
            ->andReturn($this->schemaContentsJsonResponse);

        $spy->shouldReceive('DatabaseInspect\Console\Command\file_put_contents')
            ->once()
            ->with($this->expectedFilename, $this->schemaContentsJsonResponse);

        TestHelper::$spy = $spy;
    }
}
