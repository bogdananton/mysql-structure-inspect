<?php
namespace DatabaseInspect\Persistence\DataMappers;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\NullValue\NullValue;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Persistence\Models\TableField;
use DatabaseInspect\Persistence\Models\TableIndex;

class SchemaDataMapper implements DataMapperInterface
{
    public function buildField($name, $type, $null, $key, $default, $extra)
    {
        $nameAttribute = StringLiteral::fromNative($name);
        $typeAttribute = FieldType::fromNative($type);
        $nullAttribute = ($null === 'YES');
        $keyAttribute = FieldKeyType::fromNative($key);
        $defaultAttribute = FieldDefaultValue::fromNative($default);
        $extraAttribute = StringLiteral::fromNative($extra);

        return TableField::build(
            $nameAttribute,
            $typeAttribute,
            $nullAttribute,
            $keyAttribute,
            $defaultAttribute,
            $extraAttribute
        );
    }

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
        $isNull,
        $indexType,
        $comment,
        $indexComment
    )
    {
        $tableAttribute = StringLiteral::fromNative($table);
        $nonUniqueAttribute = StringLiteral::fromNative($nonUnique);
        $keyNameAttribute = StringLiteral::fromNative($keyName);
        $seqInIndexAttribute = StringLiteral::fromNative($seqInIndex);
        $columnNameAttribute = StringLiteral::fromNative($columnName);
        $collationAttribute = StringLiteral::fromNative($collation);
        $cardinalityAttribute = StringLiteral::fromNative($cardinality);
        $subPartAttribute = (null === $subPart) ? NullValue::create() : StringLiteral::fromNative($subPart);
        $packedAttribute = (null === $packed) ? NullValue::create() : StringLiteral::fromNative($packed);
        $isNullAttribute = (bool)$isNull;
        $indexTypeAttribute = StringLiteral::fromNative($indexType);
        $commentAttribute = StringLiteral::fromNative($comment);
        $indexCommentAttribute = StringLiteral::fromNative($indexComment);

        return TableIndex::build(
            $tableAttribute,
            $nonUniqueAttribute,
            $keyNameAttribute,
            $seqInIndexAttribute,
            $columnNameAttribute,
            $collationAttribute,
            $cardinalityAttribute,
            $subPartAttribute,
            $packedAttribute,
            $isNullAttribute,
            $indexTypeAttribute,
            $commentAttribute,
            $indexCommentAttribute
        );
    }
}