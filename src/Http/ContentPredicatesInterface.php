<?php

namespace Rmk\Http;

/**
 * Interface ContentPredicatesInterface
 * @package Rmk\Http
 */
interface ContentPredicatesInterface
{

    /**
     * Checks whether the content type is JSON
     *
     * @return bool
     */
    public function isJson(): bool;

    /**
     * Checks whether the content type is XML
     *
     * @return bool
     */
    public function isXml(): bool;
}
