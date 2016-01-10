<?php
namespace DatabaseInspect\Domain\Models;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;

class TableField implements ModelInterface
{
    /** @var  StringLiteral */
    protected $name;

    /** @var  FieldType */
    protected $type;

    /** @var  bool */
    protected $isNull;

    /** @var  FieldKeyType */
    protected $key;

    /** @var  FieldDefaultValue */
    protected $default;

    /** @var  StringLiteral */
    protected $extra;

    public static function build(
        StringLiteral $name,
        FieldType $type,
        $isNull,
        FieldKeyType $key,
        FieldDefaultValue $default,
        StringLiteral $extra
    ) {
        if (!is_bool($isNull)) {
            throw new \InvalidArgumentException('The isNull argument doesn\'t have a boolean value.');
        }

        $response = new static();
        $response->name = $name;
        $response->type = $type;
        $response->isNull = $isNull;
        $response->key = $key;
        $response->default = $default;
        $response->extra = $extra;

        return $response;
    }

    public function getName()
    {
        return $this->name->toNative();
    }

    public function getType()
    {
        return $this->type->toNative();
    }

    public function getIsNull()
    {
        return $this->isNull;
    }

    public function getKey()
    {
        return $this->key->toNative();
    }

    public function getDefault()
    {
        return $this->default->toNative();
    }

    public function getExtra()
    {
        return $this->extra->toNative();
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'type' => $this->getType(),
            'null' => $this->getIsNull(),
            'key' => $this->getKey(),
            'default' => $this->getDefault(),
            'extra' => $this->getExtra(),
        ];
    }
}
