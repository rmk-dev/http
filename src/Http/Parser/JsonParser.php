<?php

namespace Rmk\Http\Parser;

use JsonException;
use Rmk\Http\Exception\ParserException;

/**
 * Class JsonParser
 * @package Rmk\Http\Parser
 */
class JsonParser implements ParserInterface
{

    /**
     * @inheritDoc
     */
    public function parse(string $content)
    {
        try {
            return json_decode($content, false, 512, JSON_THROW_ON_ERROR | JSON_BIGINT_AS_STRING);
        } catch (JsonException $e) {
            throw new ParserException('Cannot parse request body', ParserException::PARSE_ERROR, $e);
        }
    }
}
