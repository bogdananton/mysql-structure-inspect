<?php
namespace DatabaseInspect\Domain\Models;

use DatabaseInspect\Attributes\String\StringLiteral;

class Table implements ModelInterface
{
    /** @var  StringLiteral */
    protected $name;

    /** @var  TableFieldCollection */
    protected $fields;

    /** @var  TableIndexCollection */
    protected $indexes;

    public static function build(
        StringLiteral $name,
        TableFieldCollection $fields,
        TableIndexCollection $indexes
    ) {
        $response = new static();
        $response->name = $name;
        $response->fields = $fields;
        $response->indexes = $indexes;

        return $response;
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name->toNative(),
            'fields' => $this->fields->jsonSerialize(),
            'indexes' => $this->indexes->jsonSerialize(),
        ];
    }
}
