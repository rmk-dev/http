<?php

/**
 * Server request contract
 */
namespace Rmk\Http;

use Psr\Http\Message\ServerRequestInterface as PsrServerRequestInterface;

/**
 * Interface ServerRequestInterface
 *
 * @package Rmk\Http
 */
interface ServerRequestInterface extends RequestInterface, ContentPredicatesInterface, PsrServerRequestInterface
{

    /**
     * Checks whether the request body is in url-form-encoded form
     *
     * @return bool
     */
    public function isUrlFormEncoded(): bool;
}
