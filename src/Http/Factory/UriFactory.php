<?php

/**
 * URI factory class
 */
namespace Rmk\Http\Factory;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Rmk\Http\Uri;

/**
 * Class UriFactory
 * @package Rmk\Http\Factory
 */
class UriFactory implements UriFactoryInterface
{

    /**
     * @inheritDoc
     */
    public function createUri(string $uri = ''): UriInterface
    {
        return new Uri($uri);
    }
}
