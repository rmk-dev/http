<?php

/**
 * Response factory flass
 */
namespace Rmk\Http\Factory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Rmk\Http\Response;

class ResponseFactory implements ResponseFactoryInterface
{

    /**
     * @param int $code
     * @param string $reasonPhrase
     * @param array $headers
     * @param null $body
     * @param string $version
     *
     * @return ResponseInterface
     */
    public function createResponse(
        int $code = 200,
        string $reasonPhrase = '',
        array $headers = [],
        $body = null,
        string $version = '1.1'
    ): ResponseInterface {
        return new Response($code, $headers, $body, $version, $reasonPhrase);
    }
}