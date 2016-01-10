<?php
namespace DatabaseInspect\Domain\Models;

use DatabaseInspect\Attributes\String\StringLiteral;

interface CredentialsInterface extends ModelInterface
{
    public function getUsername();
    public function getPassword();
    public function getHost();
    public function getDatabase();

    public static function build(
        StringLiteral $username,
        StringLiteral $password,
        StringLiteral $host,
        StringLiteral $database
    );
}