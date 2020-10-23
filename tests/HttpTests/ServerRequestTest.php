<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Factory\ServerRequestFactory;
use Rmk\Http\Uri;
use function GuzzleHttp\Psr7\stream_for;

/**
 * Class ServerRequestTest
 * @package Rmk\HttpTests
 */
class ServerRequestTest extends TestCase
{
    use HttpMessageTestTrait;

    protected function setUp(): void
    {
        $factory = new ServerRequestFactory();
        $this->message = $factory->createServerRequest('GET', new Uri('http://example.com'));
    }

    public function testIsUrlFormEncoded()
    {
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/x-www-form-urlencoded')->isUrlFormEncoded());
        $this->assertTrue($this->message->withHeader('Content-Type', 'multipart/form-data')->isUrlFormEncoded());
        $this->assertTrue($this->message->withHeader('Content-Type', 'text/plain')->isUrlFormEncoded());
        $this->assertFalse($this->message->withHeader('Content-Type', 'text/html')->isUrlFormEncoded());
        $this->message = (new ServerRequestFactory())->createFromSuperglobals();
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/x-www-form-urlencoded')->isUrlFormEncoded());
        $this->assertTrue($this->message->withHeader('Content-Type', 'multipart/form-data')->isUrlFormEncoded());
        $this->assertTrue($this->message->withHeader('Content-Type', 'text/plain')->isUrlFormEncoded());
        $this->assertFalse($this->message->withHeader('Content-Type', 'text/html')->isUrlFormEncoded());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/json')->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/vnd.microsoft+json')->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/hal+json')->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/vnd.some-provider+json;version=2.0')->isJson());
        $this->assertTrue($this->message->withHeader('Content-Type', 'application/x-web-app-manifest+json')->isJson());
        $this->assertFalse($this->message->withHeader('Content-Type', 'application/haljson')->isJson());
    }

    public function testParsedBody()
    {
        $factory = new ServerRequestFactory();
        $headers = ['Content-Type' => 'application/json'];
        $body = '{"a":1,"b":"test string"}';
        $request = $factory->createServerRequest('POST', new Uri('http://example.com'), [], $headers, $body);
        $parsedBody = $request->getParsedBody();
        $this->assertTrue($request->isJson());
        $this->assertInstanceOf(\stdClass::class, $parsedBody);
        $this->assertEquals(1, $parsedBody->a);
        $this->assertEquals('test string', $parsedBody->b);
    }
}
