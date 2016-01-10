<?php
namespace tests\unit\lib\Domain\Models\MySQLCredentials;

use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\MySQLCredentials;

class ToArrayTest extends \PHPUnit_Framework_TestCase
{
    protected $username = 'Alphanum_123';
    protected $password = 'Alphanum1234567890-=~!#$%^&*()[]_+?<>'; // not included: ` : ; " ' @ /
    protected $hostnameLiteral = 'localhost';
    protected $database = 'employees_2016';

    /**
     * When called will return the credential contents as an associative array.
     */
    public function testWhenCalledWillReturnTheCredentialContentsAsAnAssociativeArray()
    {
        $object = MySQLCredentials::build(
            StringLiteral::fromNative($this->username),
            StringLiteral::fromNative($this->password),
            StringLiteral::fromNative($this->hostnameLiteral),
            StringLiteral::fromNative($this->database)
        );

        $response = $object->toArray();
        $expected = [
            'username' => 'Alphanum_123',
            'password' => 'Alphanum1234567890-=~!#$%^&*()[]_+?<>',
            'host' => 'localhost',
            'database' => 'employees_2016',
        ];

        static::assertEquals($expected, $response);
    }
}
