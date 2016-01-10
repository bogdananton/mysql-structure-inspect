<?php
namespace DatabaseInspect\Persistence\DataMappers;

interface DataMapperInterface
{
    public function buildField(
        $field,
        $type,
        $null,
        $key,
        $default,
        $extra
    );

    public function buildIndex(
        $table,
        $nonUnique,
        $keyName,
        $seqInIndex,
        $columnName,
        $collation,
        $cardinality,
        $subPart,
        $packed,
        $null,
        $indexType,
        $comment,
        $indexComment
    );
}
