<?php
namespace DatabaseInspect\Domain\Models;

class TableIndexCollection implements ModelInterface
{
    /** @var  TableIndex[] */
    protected $entries = [];

    public static function build(array $entries = [])
    {
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            /** @var TableField $field */
            $field = $entries[$i];

            if (false === ($field instanceof TableIndex)) {
                throw new \InvalidArgumentException('Invalid index entries.');
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
            /** @var TableIndex $field */
            $index = $this->entries[$i];
            $response[] = $index->jsonSerialize();
        }

        return $response;
    }
}
