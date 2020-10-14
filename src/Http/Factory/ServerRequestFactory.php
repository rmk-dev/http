<?php

/**
 * Server request factory class
 */

namespace Rmk\Http\Factory;

use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Rmk\Http\ServerRequest;

/**
 * Class ServerRequestFactory
 * @package Rmk\Http\Factory
 */
class ServerRequestFactory implements ServerRequestFactoryInterface
{

    /**
     * @param string $method
     * @param UriInterface|string $uri
     * @param array $serverParams
     * @param array $headers
     * @param mixed $body
     * @param string $version
     *
     * @return ServerRequestInterface
     */
    public function createServerRequest(
        string $method,
        $uri,
        array $serverParams = [],
        array $headers = [],
        $body = null,
        string $version = '1.1'
    ): ServerRequestInterface {
        $request = new ServerRequest($method, $uri, $headers, $body, $version, $serverParams);
        if ($body) {
            $request = $this->addParsedBody($body, $request);
        }

        return $request;
    }

    public function createFromSuperglobals(): ServerRequestInterface
    {
        $response = ServerRequest::fromGlobals();

        return $this->createServerRequest(
            $response->getMethod(),
            $response->getUri(),
            $response->getServerParams(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion()
        )->withUploadedFiles($response->getUploadedFiles());
    }

    protected function addParsedBody($body, $request)
    {
        $parserStrategy = (new ParserStrategyFactory())->create();
        $parser = $parserStrategy->getParser($request);
        if ($parser) {
            $request = $request->withParsedBody($parser->parse($body . ''));
        }

        return $request;
    }
}
