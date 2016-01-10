<?php
namespace DatabaseInspect\Attributes\Exceptions;

class UnexpectedValueException extends InvalidNativeArgumentException
{
    const ERROR_MESSAGE = 'Argument %s is invalid. Expected value patterns are "%s".';
}
