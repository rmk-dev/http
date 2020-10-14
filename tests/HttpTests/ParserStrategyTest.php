<?php

namespace HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Exception\ParserException;
use Rmk\Http\Factory\ParserStrategyFactory;
use Rmk\Http\Parser\FormEncodedParser;
use Rmk\Http\Parser\JsonParser;
use Rmk\Http\Parser\ParserStrategy;
use Rmk\Http\Parser\XmlParser;
use Rmk\Http\ServerRequest;

class ParserStrategyTest extends TestCase
{

    public function testGetParsers()
    {
        $strategy = (new ParserStrategyFactory())->create();
        $jsonRequest = new ServerRequest('POST', 'http://example.com', ['Content-Type' => ['application/json']]);
        $this->assertInstanceOf(JsonParser::class, $strategy->getParser($jsonRequest));
        $xmlRequest = new ServerRequest('POST', 'http://example.com', ['Content-Type' => ['application/xml']]);
        $this->assertInstanceOf(XmlParser::class, $strategy->getParser($xmlRequest));
        $formRequest = new ServerRequest('POST', 'http://example.com', ['Content-Type' => ['application/x-www-form-urlencoded']]);
        $this->assertInstanceOf(FormEncodedParser::class, $strategy->getParser($formRequest));
    }

    public function testInvalidParser()
    {
        $strategy = new ParserStrategy([
            ParserStrategy::JSON_PARSER_KEY => new \stdClass(),
        ]);
        $this->expectException(ParserException::class);
        $this->expectExceptionCode(ParserException::INVALID_PARSER);
        $strategy->getParser(new ServerRequest('POST', 'http://example.com', ['Content-Type' => ['application/json']]));
    }
}
