<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Parser\FormEncodedParser;

/**
 * Class FormEncodedParser
 * @package Rmk\HttpTests
 */
class FormEncodedParserTest extends TestCase
{

    public function testParse()
    {
        $str = 'name1=value1&name2=value2&name3=value3';
        $parser = new FormEncodedParser();
        $value = $parser->parse($str);
        $this->assertIsArray($value);
        $this->assertArrayHasKey('name1', $value);
        $this->assertContains('value1', $value);
        $this->assertArrayHasKey('name2', $value);
        $this->assertContains('value2', $value);
        $this->assertArrayHasKey('name3', $value);
        $this->assertContains('value3', $value);
    }
}