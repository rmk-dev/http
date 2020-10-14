<?php

namespace Rmk\HttpTests;

use Psr\Http\Message\MessageInterface;

trait HttpMessageTestTrait
{

    /**
     * @var MessageInterface
     */
    protected $message;

    public function testIsJson()
    {
        $this->assertFalse($this->message->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/json')->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/vnd.api+json')->isJson());
        $this->assertFalse($this->message->withHeader('Content-Type', 'whateva')->isJson());
    }

    public function testIsXml()
    {
        $this->assertFalse($this->message->isXml());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/xml')->isXml());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/xml-dtd')->isXml());
        $this->assertFalse($this->message->withHeader('Content-Type', 'whateva')->isXml());
    }
}