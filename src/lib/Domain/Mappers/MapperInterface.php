<?php
namespace DatabaseInspect\Domain\Mappers;

use DatabaseInspect\Domain\Models\CredentialsInterface;
use DatabaseInspect\Domain\Models\Table;
use DatabaseInspect\Domain\Models\TableFieldCollection;
use DatabaseInspect\Domain\Models\TableIndexCollection;

interface MapperInterface
{
    const REGEX_CREDENTIALS_INLINE = '/([\w]+)\:([\w\-\=\~\!\#\$\%\^\&\*\(\)\[\]\_\+\?\<\>]+)@([\w\.]+)\/([\w]+)/';

    /**
     * @param string $credentialsInline
     *
     * @return CredentialsInterface
     */
    public function buildCredentialsFromInlineFormat($credentialsInline);

    /**
     * @param string $name
     * @param string $type
     * @param bool   $isNull
     * @param string $key
     * @param string $default
     * @param string $extra
     *
     * @return static
     */
    public function buildField($name, $type, $isNull, $key, $default, $extra);

    /**
     * @param \DatabaseInspect\Persistence\Models\TableField[] $fields
     *
     * @return TableFieldCollection
     */
    public function buildTableFieldCollectionFromPersistence(array $fields);

    /**
     * @param \DatabaseInspect\Persistence\Models\TableIndex[] $indexes
     *
     * @return TableIndexCollection
     */
    public function buildTableIndexCollectionFromPersistence(array $indexes);

    /**
     * @param string $tableName
     * @param \DatabaseInspect\Persistence\Models\TableField[] $fieldEntries
     * @param \DatabaseInspect\Persistence\Models\TableIndex[] $indexEntries
     *
     * @return Table
     */
    public function buildTableFromPersistence($tableName, $fieldEntries, $indexEntries);
}
