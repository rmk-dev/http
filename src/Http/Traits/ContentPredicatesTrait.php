<?php

namespace Rmk\Http\Traits;

/**
 * Trait ContentPredicatesTraot
 * @package Rmk\Http\Traits
 */
trait ContentPredicatesTrait
{

    /**
     * Checks whether the content type is JSON
     *
     * @return bool
     */
    public function isJson(): bool
    {
        $contentType = $this->getHeaderLine('Content-Type');
        if ($contentType) {
            return (bool) preg_match('/application\/([\w\-\.]+\+)?json/i', $contentType);
        }

        return false;
    }

    /**
     * Checks whether the content type is XML
     *
     * @return bool
     */
    public function isXml(): bool
    {
        $contentType = $this->getHeaderLine('Content-Type');
        if ($contentType) {
            return (bool) preg_match('/(application|text)\/xml\-?/i', $contentType);
        }

        return false;
    }
}