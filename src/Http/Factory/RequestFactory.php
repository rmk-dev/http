<?php

/**
 * Request factory class
 */
namespace Rmk\Http\Factory;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Rmk\Http\Request;

/**
 * Class RequestFactory
 * @package Rmk\Http\Factory
 */
class RequestFactory implements RequestFactoryInterface
{

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $headers
     * @param mixed|null $body
     *
     * @return RequestInterface
     */
    public function createRequest(string $method, $uri, $headers = [], $body = null): RequestInterface
    {
        return new Request($method, $uri, $headers, $body);
    }
}
