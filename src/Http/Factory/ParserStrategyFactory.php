<?php

namespace Rmk\Http\Factory;

use Rmk\Http\Parser\FormEncodedParser;
use Rmk\Http\Parser\JsonParser;
use Rmk\Http\Parser\ParserStrategy;
use Rmk\Http\Parser\XmlParser;

/**
 * Class ParserStrategyFactory
 * @package Rmk\Http\Factory
 */
class ParserStrategyFactory
{

    public function create(): ParserStrategy
    {
        // TODO Move parsers to DI
        return new ParserStrategy([
            ParserStrategy::JSON_PARSER_KEY => new JsonParser(),
            ParserStrategy::XML_PARSER_KEY => new XmlParser(),
            ParserStrategy::FORM_PARSER_KEY => new FormEncodedParser(),
        ]);
    }
}