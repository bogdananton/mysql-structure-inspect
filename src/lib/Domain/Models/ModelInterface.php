<?php
namespace DatabaseInspect\Domain\Models;

interface ModelInterface extends \JsonSerializable
{
    public function toArray();
}
