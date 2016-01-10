<?php
namespace DatabaseInspect\Domain\Models;

class TableFieldCollection implements ModelInterface
{
    /** @var  TableField[] */
    protected $entries = [];

    public static function build(array $entries = [])
    {
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            /** @var TableField $field */
            $field = $entries[$i];

            if (false === ($field instanceof TableField)) {
                throw new \InvalidArgumentException('Invalid field entries.');
            }
        }

        $response = new static();
        $response->entries = $entries;

        return $response;
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        $response = [];
        $length = count($this->entries);

        for ($i = 0; $i < $length; $i++) {
            /** @var TableField $field */
            $field = $this->entries[$i];
            $response[] = $field->jsonSerialize();
        }

        return $response;
    }
}
