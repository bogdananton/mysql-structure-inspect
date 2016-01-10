<?php
namespace DatabaseInspect\Console\Command;

use tests\TestHelper;

function json_encode()
{
    return TestHelper::bypassOrPassthru(__FUNCTION__, func_get_args());
}

function date()
{
    return TestHelper::bypassOrPassthru(__FUNCTION__, func_get_args());
}

function file_put_contents()
{
    return TestHelper::bypassOrPassthru(__FUNCTION__, func_get_args());
}
