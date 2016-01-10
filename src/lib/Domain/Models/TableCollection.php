<?php
namespace DatabaseInspect\Domain\Models;

class TableCollection implements ModelInterface
{
    /** @var  Table[] */
    protected $entries = [];

    public static function build(array $entries = [])
    {
        $length = count($entries);

        for ($i = 0; $i < $length; $i++) {
            /** @var Table $table */
            $table = $entries[$i];

            if (false === ($table instanceof Table)) {
                throw new \InvalidArgumentException('Invalid Table entries.');
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
            /** @var Table $table */
            $table = $this->entries[$i];
            $response[] = $table->jsonSerialize();
        }

        return $response;
    }
}