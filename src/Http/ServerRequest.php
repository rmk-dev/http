<?php

/**
 * Server request class
 */
namespace Rmk\Http;

use GuzzleHttp\Psr7\ServerRequest as GuzzleServerRequest;
use Rmk\Http\Traits\ContentPredicatesTrait;

/**
 * Class ServerRequest
 *
 * @package Rmk\Http
 */
class ServerRequest extends GuzzleServerRequest implements ServerRequestInterface
{
    use ContentPredicatesTrait;

    /**
     * Checks whether the request body is in url-form-encoded form
     *
     * @return bool
     */
    public function isUrlFormEncoded(): bool
    {
        return (bool) preg_match(
            '/(application\/x-www-form-urlencoded|multipart\/form-data|text\/plain)/i',
            $this->getHeaderLine('Content-Type')
        );
    }
}
