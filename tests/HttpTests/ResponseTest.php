<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Factory\ResponseFactory;

/**
 * Class ResponseTest
 * @package HttpTests
 */
class ResponseTest extends TestCase
{
    use HttpMessageTestTrait;

    protected function setUp(): void
    {
        $factory = new ResponseFactory();
        $this->message = $factory->createResponse(200, 'OK');
    }

    public function testIsHtml()
    {
        $this->assertFalse($this->message->isHtml());
        $this->assertTrue($this->message->withHeader('Content-Type', 'text/html; charset=utf-8')->isHtml());
        $this->assertFalse($this->message->withHeader('Content-Type', 'whateva')->isHtml());
    }

    public function testIsPlainText()
    {
        $this->assertFalse($this->message->isPlainText());
        $this->assertTrue($this->message->withHeader('Content-Type', 'text/plain; charset=utf-8')->isPlainText());
        $this->assertFalse($this->message->withHeader('Content-Type', 'whateva')->isPlainText());
    }
}