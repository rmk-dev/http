<?php

/**
 * The Terry request class
 */
namespace Rmk\Http;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

/**
 * Class Request
 *
 * @package Rmk\Http
 */
class Request extends GuzzleRequest implements RequestInterface
{
    public function getUri()
    {
        return new Uri(parent::getUri() . '');
    }
}
