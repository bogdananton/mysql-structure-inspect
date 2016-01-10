<?php
namespace DatabaseInspect\Domain\Mappers;

use DatabaseInspect\Attributes\Database\FieldDefaultValue;
use DatabaseInspect\Attributes\Database\FieldKeyType;
use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\NullValue\NullValue;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Domain\Models\CredentialsInterface;
use DatabaseInspect\Domain\Models\Table;
use DatabaseInspect\Domain\Models\TableField;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndex;
use DatabaseInspect\Domain\Models\TableIndexCollection;
use DatabaseInspect\Domain\Models\MySQLCredentials;

class SchemaMapper implements MapperInterface
{
    /**
     * @param string $credentialsInline
     *
     * @return CredentialsInterface
     * @throws \Exception
     */
    public function buildCredentialsFromInlineFormat($credentialsInline)
    {
        preg_match(self::REGEX_CREDENTIALS_INLINE, $credentialsInline, $match);

        if (count($match) === 5) {
            array_shift($match);
        } else {
            throw new \Exception('Invalid credentials format.');
        }

        $username = StringLiteral::fromNative($match[0]);
        $password = StringLiteral::fromNative($match[1]);
        $host = StringLiteral::fromNative($match[2]);
        $database = StringLiteral::fromNative($match[3]);

        $credentials = MySQLCredentials::build($username, $password, $host, $database);

        return $credentials;
    }

    public function buildTableFieldCollectionFromPersistence(array $fields)
    {
        $fieldList = [];
        $length = count($fields);

        for ($i = 0; $i < $length; $i++) {
            /** @var \DatabaseInspect\Persistence\Models\TableField $persistenceField */
            $persistenceField = $fields[$i];
            // @todo Throw exception when the item is not a TableField.

            $name = $persistenceField->getName();
            $type = $persistenceField->getType();
            $null = $persistenceField->getIsNull();
            $key = $persistenceField->getKey();
            $default = $persistenceField->getDefault();
            $extra = $persistenceField->getExtra();

            $domainField = $this->buildField($name, $type, $null, $key, $default, $extra);
            $fieldList[] = $domainField;
        }

        return TableFieldCollection::build($fieldList);
    }

    public function buildTableIndexCollectionFromPersistence(array $indexes)
    {
        $indexList = [];
        $length = count($indexes);

        for ($i = 0; $i < $length; $i++) {
            /** @var \DatabaseInspect\Persistence\Models\TableIndex $persistenceIndex */
            $persistenceIndex = $indexes[$i];
            // @todo Throw exception when the item is not a TableIndex.

            $table = $persistenceIndex->getTable();
            $nonUnique = $persistenceIndex->getNonUnique();
            $keyName = $persistenceIndex->getKeyName();
            $seqInIndex = $persistenceIndex->getSeqInIndex();
            $columnName = $persistenceIndex->getColumnName();
            $collation = $persistenceIndex->getCollation();
            $cardinality = $persistenceIndex->getCardinality();
            $subPart = $persistenceIndex->getSubPart();
            $packed = $persistenceIndex->getPacked();
            $isNull = $persistenceIndex->getIsNull();
            $indexType = $persistenceIndex->getIndexType();
            $comment = $persistenceIndex->getComment();
            $indexComment = $persistenceIndex->getIndexComment();

            $domainIndex = $this->buildIndex(
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
            );

            $indexList[] = $domainIndex;
        }

        return TableIndexCollection::build($indexList);
    }

    public function buildField(
        $name,
        $type,
        $isNull,
        $key,
        $default,
        $extra
    ) {
        $nameAttribute = StringLiteral::fromNative($name);
        $typeAttribute = FieldType::fromNative($type);
        $nullAttribute = (bool)$isNull;
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

    /**
     * @todo improve types for TableIndex attributes
     *
     * @param $table
     * @param $nonUnique
     * @param $keyName
     * @param $seqInIndex
     * @param $columnName
     * @param $collation
     * @param $cardinality
     * @param $subPart
     * @param $packed
     * @param $isNull
     * @param $indexType
     * @param $comment
     * @param $indexComment
     *
     * @return TableIndex
     */
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
    ) {
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

        $tableIndex = TableIndex::build(
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

        return $tableIndex;
    }

    /**
     * @param string                                           $tableName
     * @param \DatabaseInspect\Persistence\Models\TableField[] $fieldEntries
     * @param \DatabaseInspect\Persistence\Models\TableIndex[] $indexEntries
     *
     * @return static
     */
    public function buildTableFromPersistence($tableName, $fieldEntries, $indexEntries)
    {
        $tableName = StringLiteral::fromNative($tableName);
        $indexCollection = $this->buildTableIndexCollectionFromPersistence($indexEntries);
        $fieldCollection = $this->buildTableFieldCollectionFromPersistence($fieldEntries);

        $table = Table::build($tableName, $fieldCollection, $indexCollection);
        return $table;
    }
}
