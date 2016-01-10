<?php
namespace DatabaseInspect\Attributes\Exceptions;

/**
 * The exception will be thrown when an invalid native argument is supplied to a value object.
 */
class InvalidNativeArgumentException extends \InvalidArgumentException
{
    const ERROR_MESSAGE = 'Argument %s is invalid. Allowed types are "%s".';

    /**
     * Prepares the message using the input value and an array of allowed native types.
     *
     * @param string $value
     * @param string[]  $allowedTypes
     */
    public function __construct($value, array $allowedTypes)
    {
        $value = $this->prepareStringValue($value);
        $this->message = sprintf(static::ERROR_MESSAGE, $value, implode(', ', $allowedTypes));
    }

    /**
     * Wraps the value for safe usage in a string context when building the error message.
     * If the value is null then the output is "NULL".
     * If the value is an array or an object, the output will be "Array" or "Object"
     * Else, will wrap the value in double quotes.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function prepareStringValue($value)
    {
        switch (true) {
            case null === $value:
                $value = 'NULL';
                break;

            case is_array($value):
                $value = 'Array';
                break;

            case is_object($value):
                $value = 'Object';
                break;

            default:
                $value = '"' . $value . '"';
                break;
        }

        return $value;
    }
}