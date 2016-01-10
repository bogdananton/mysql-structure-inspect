<?php
namespace tests\unit\lib\Domain\Mappers\SchemaMapper;

use DatabaseInspect\Domain\Mappers\SchemaMapper;
use DatabaseInspect\Domain\Models\CredentialsInterface;
use DatabaseInspect\Domain\Models\MySQLCredentials;

class BuildCredentialsFromInlineFormatTest extends \PHPUnit_Framework_TestCase
{
    protected $username = 'Alphanum_123';
    protected $password = 'Alphanum1234567890-=~!#$%^&*()[]_+?<>'; // not included: ` : ; " ' @ /
    protected $hostnameLiteral = 'localhost';
    protected $hostnameIPv4 = '127.0.0.1';
    protected $database = 'employees_2016';

    /**
     * When an invalid format is given then throw exception.
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid credentials format.
     */
    public function testWhenAnInvalidFormatIsGivenThenThrowException()
    {
        $input = 'user:pass@host';
        $mapper = new SchemaMapper();
        $mapper->buildCredentialsFromInlineFormat($input);
    }

    /**
     * When a valid format is given then return mysql credentials object.
     */
    public function testWhenAValidFormatIsGivenThenReturnMysqlCredentialsObject()
    {
        $input = $this->username . ':' . $this->password . '@' . $this->hostnameLiteral . '/' . $this->database;
        $mapper = new SchemaMapper();
        $response = $mapper->buildCredentialsFromInlineFormat($input);

        static::assertInstanceOf(MySQLCredentials::class, $response);
        return $response;
    }

    /**
     * The built object will have the detected parts stored.
     * @depends testWhenAValidFormatIsGivenThenReturnMysqlCredentialsObject
     * @param CredentialsInterface $credentials
     */
    public function testTheBuiltObjectWillHaveTheDetectedPartsStored(CredentialsInterface $credentials)
    {
        static::assertEquals($this->username, $credentials->getUsername());
        static::assertEquals($this->password, $credentials->getPassword());
        static::assertEquals($this->hostnameLiteral, $credentials->getHost());
        static::assertEquals($this->database, $credentials->getDatabase());
    }

    /**
     * When the hostname is an IP then build credentials object.
     */
    public function testWhenTheHostnameIsAnIPThenBuildObject()
    {
        $input = $this->username . ':' . $this->password . '@' . $this->hostnameIPv4 . '/' . $this->database;
        $mapper = new SchemaMapper();
        $credentials = $mapper->buildCredentialsFromInlineFormat($input);
        static::assertEquals($this->hostnameIPv4, $credentials->getHost());
    }
}
