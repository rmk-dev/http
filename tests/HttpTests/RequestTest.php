<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Factory\RequestFactory;
use Rmk\Http\Uri;

class RequestTest extends TestCase
{

    public function testReturnTerryUri(): void
    {
        $factory = new RequestFactory();
        $request = $factory->createRequest('GET', 'https://example.com/users/login?err=1#log');
        $uri = $request->getUri();
        $this->assertInstanceOf(Uri::class, $uri);
        $this->assertEquals('https', $uri->getScheme());
        $this->assertEquals('example.com', $uri->getHost());
        $this->assertEquals('/users/login', $uri->getPath());
        $this->assertEquals('err=1', $uri->getQuery());
        $this->assertEquals('log', $uri->getFragment());
        $this->assertNull($uri->getPort());
        $this->assertEmpty($uri->getUserInfo());
    }
}