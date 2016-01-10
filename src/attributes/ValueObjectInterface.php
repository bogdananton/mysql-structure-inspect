<?php
namespace DatabaseInspect\Attributes;

interface ValueObjectInterface
{
    public static function fromNative();
    public function toNative();
}