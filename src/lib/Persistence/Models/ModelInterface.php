<?php
namespace DatabaseInspect\Persistence\Models;

interface ModelInterface extends \JsonSerializable
{
    public function toArray();
}