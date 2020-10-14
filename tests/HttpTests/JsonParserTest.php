<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Exception\ParserException;
use Rmk\Http\Parser\JsonParser;

class JsonParserTest extends TestCase
{

    public function testParse()
    {
        $jsonString = '{"a":1,"b":"Test value"}';
        $parser = new JsonParser();
        $parsedValue = $parser->parse($jsonString);
        $this->assertInstanceOf(\stdClass::class, $parsedValue);
        $this->assertTrue(isset($parsedValue->a));
        $this->assertTrue(isset($parsedValue->b));
        $this->assertEquals(1, $parsedValue->a);
        $this->assertEquals('Test value', $parsedValue->b);
    }

    public function testParseFail()
    {
        $jsonString = '{"a":1,"b":"Test value';
        $parser = new JsonParser();
        $this->expectException(ParserException::class);
        $this->expectExceptionCode(ParserException::PARSE_ERROR);
        $this->expectExceptionMessage('Cannot parse request body');
        $parser->parse($jsonString);
    }
}
