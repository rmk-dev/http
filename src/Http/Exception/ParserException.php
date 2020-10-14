<?php

namespace Rmk\Http\Exception;

use RuntimeException;

/**
 * Class ParserException
 *
 * @package Rmk\Http\Exception
 */
class ParserException extends RuntimeException
{

    public const PARSE_ERROR = 1;

    public const INVALID_PARSER = 2;

    public const NO_PARSER = 3;
}
