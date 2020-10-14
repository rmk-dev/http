<?php

namespace Rmk\HttpTests;

use PHPUnit\Framework\TestCase;
use Rmk\Http\Factory\UriFactory;
use Rmk\Http\Uri;

class UriFactoryTest extends TestCase
{

    public function testUriFactory(): void
    {
        $factory = new UriFactory();
        $uri = $factory->createUri('https://example.com/users/login?err=1#log');
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