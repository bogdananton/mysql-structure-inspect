<?php
namespace tests;

use DatabaseInspect\Attributes\ValueObjectInterface as VO;
use Mockery\MockInterface;

/**
 * Helper class, containing additional methods.
 */
class TestHelper
{
    /** @var null|\Mockery\MockInterface */
    public static $spy;

    /**
     * Helper method that checks a value object's value.
     *
     * @param VO $instance
     * @param string $checkedValue
     * @param string $attributeName
     */
    public static function assertValueObjectHasValue(VO $instance, $checkedValue, $attributeName = 'value')
    {
        $value = \PHPUnit_Framework_Assert::readAttribute($instance, $attributeName);
        \PHPUnit_Framework_TestCase::assertSame($checkedValue, $value);
    }

    public static function bypassOrPassthru($function, array $args = [])
    {
        $spy = self::$spy;

        if ($spy instanceof MockInterface) {
            return call_user_func_array([$spy, $function], $args);
        }

        return call_user_func_array($function, $args);
    }
}
