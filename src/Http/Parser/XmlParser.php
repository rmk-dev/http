<?php

namespace Rmk\Http\Parser;

use Rmk\Http\Exception\ParserException;

/**
 * Class XmlParser
 * @package Rmk\Http\Parser
 */
class XmlParser implements ParserInterface
{

    public function __construct()
    {
        libxml_use_internal_errors(true);
    }

    public function parse(string $content)
    {
        $data = simplexml_load_string($content);
        if ($data === false) {
            throw new ParserException('Cannot parse request body', ParserException::PARSE_ERROR);
        }

        return $data;
    }
}
