<?php
namespace DatabaseInspect\Domain\Models;

use DatabaseInspect\Attributes\String\StringLiteral;

class MySQLCredentials implements CredentialsInterface
{
    /** @var  StringLiteral */
    protected $username;

    /** @var  StringLiteral */
    protected $password;

    /** @var  StringLiteral */
    protected $host;

    /** @var  StringLiteral */
    protected $database;

    public static function build(
        StringLiteral $username,
        StringLiteral $password,
        StringLiteral $host,
        StringLiteral $database
    )
    {
        $response = new static();
        $response->username = $username;
        $response->password = $password;
        $response->host = $host;
        $response->database = $database;

        return $response;
    }

    public function getUsername()
    {
        return $this->username->toNative();
    }

    public function getPassword()
    {
        return $this->password->toNative();
    }

    public function getHost()
    {
        return $this->host->toNative();
    }

    public function getDatabase()
    {
        return $this->database->toNative();
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return [
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
            'host' => $this->getHost(),
            'database' => $this->getDatabase()
        ];
    }
}
