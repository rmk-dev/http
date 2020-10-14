<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Exception\ParserException;
use Rmk\Http\Parser\XmlParser;

class XmlParserTest extends TestCase
{

    public function testParse(): void
    {
        $xmlString = '<root><node id="1">Node content</node><node id="2"><sometag /></node></root>';
        $parser = new XmlParser();
        $parsedValue = $parser->parse($xmlString);
        $this->assertInstanceOf(\SimpleXMLElement::class, $parsedValue);
        $this->assertTrue(isset($parsedValue->node));
        $this->assertTrue(isset($parsedValue->node[0]));
        $this->assertEquals(1, $parsedValue->node[0]['id'] . '');
        $this->assertTrue(isset($parsedValue->node[1]));
        $this->assertEquals(2, $parsedValue->node[1]['id'] . '');
        $this->assertTrue(isset($parsedValue->node[1]->sometag));
    }

    public function testParseFail(): void
    {
        $xmlString = '<root><node id="1">Node content</node><node id="2"><sometag /></node>';
        $parser = new XmlParser();
        $this->expectException(ParserException::class);
        $this->expectExceptionCode(ParserException::PARSE_ERROR);
        $this->expectExceptionMessage('Cannot parse request body');
        $parser->parse($xmlString);
    }
}
