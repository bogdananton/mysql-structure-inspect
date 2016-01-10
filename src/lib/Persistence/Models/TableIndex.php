<?php
namespace DatabaseInspect\Persistence\Models;

use DatabaseInspect\Attributes\Database\FieldType;
use DatabaseInspect\Attributes\String\StringLiteral;
use DatabaseInspect\Attributes\ValueObjectInterface;

class TableIndex implements ModelInterface
{
    /** @var  StringLiteral */
    protected $table;

    /** @var  StringLiteral */
    protected $nonUnique;

    /** @var  StringLiteral */
    protected $keyName;

    /** @var  StringLiteral */
    protected $seqInIndex;

    /** @var  StringLiteral */
    protected $columnName;

    /** @var  StringLiteral */
    protected $collation;

    /** @var  StringLiteral */
    protected $cardinality;

    /** @var  StringLiteral */
    protected $subPart;

    /** @var  StringLiteral */
    protected $packed;

    /** @var  StringLiteral */
    protected $isNull;

    /** @var  StringLiteral */
    protected $indexType;

    /** @var  StringLiteral */
    protected $comment;

    /** @var  StringLiteral */
    protected $indexComment;

    public static function build(
        ValueObjectInterface $table,
        ValueObjectInterface $nonUnique,
        ValueObjectInterface $keyName,
        ValueObjectInterface $seqInIndex,
        ValueObjectInterface $columnName,
        ValueObjectInterface $collation,
        ValueObjectInterface $cardinality,
        ValueObjectInterface $subPart,
        ValueObjectInterface $packed,
        $isNull,
        ValueObjectInterface $indexType,
        ValueObjectInterface $comment,
        ValueObjectInterface $indexComment
    )
    {
        if (!is_bool($isNull)) {
            throw new \InvalidArgumentException('The isNull argument doesn\'t have a boolean value.');
        }

        $response = new static();
        $response->table = $table;
        $response->nonUnique = $nonUnique;
        $response->keyName = $keyName;
        $response->seqInIndex = $seqInIndex;
        $response->columnName = $columnName;
        $response->collation = $collation;
        $response->cardinality = $cardinality;
        $response->subPart = $subPart;
        $response->packed = $packed;
        $response->isNull = $isNull;
        $response->indexType = $indexType;
        $response->comment = $comment;
        $response->indexComment = $indexComment;

        return $response;
    }

    public function getTable()
    {
        return $this->table->toNative();
    }

    public function getNonUnique()
    {
        return $this->nonUnique->toNative();
    }
    public function getKeyName()
    {
        return $this->keyName->toNative();
    }
    public function getSeqInIndex()
    {
        return $this->seqInIndex->toNative();
    }
    public function getColumnName()
    {
        return $this->columnName->toNative();
    }
    public function getCollation()
    {
        return $this->collation->toNative();
    }
    public function getCardinality()
    {
        return $this->cardinality->toNative();
    }
    public function getSubPart()
    {
        return $this->subPart->toNative();
    }
    public function getPacked()
    {
        return $this->packed->toNative();
    }
    public function getIsNull()
    {
        return $this->isNull;
    }
    public function getIndexType()
    {
        return $this->indexType->toNative();
    }
    public function getComment()
    {
        return $this->comment->toNative();
    }
    public function getIndexComment()
    {
        return $this->indexComment->toNative();
    }

    public function toArray()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return [
            'table' => $this->getTable(),
            'nonUnique' => $this->getNonUnique(),
            'keyName' => $this->getKeyName(),
            'seqInIndex' => $this->getSeqInIndex(),
            'columnName' => $this->getColumnName(),
            'collation' => $this->getCollation(),
            'cardinality' => $this->getCardinality(),
            'subPart' => $this->getSubPart(),
            'packed' => $this->getPacked(),
            'isNull' => $this->getIsNull(),
            'indexType' => $this->getIndexType(),
            'comment' => $this->getComment(),
            'indexComment' => $this->getIndexComment(),
        ];
    }
}
