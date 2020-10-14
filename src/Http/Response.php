<?php

/**
 * Response class
 */
namespace Rmk\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Rmk\Http\Traits\ContentPredicatesTrait;

/**
 * Class Response
 *
 * @package Rmk\Http
 */
class Response extends GuzzleResponse implements ResponseInterface
{
    use ContentPredicatesTrait;

    /**
     * Checks whether the content type is HTML
     *
     * @return bool
     */
    public function isHtml(): bool
    {
        $contentType = $this->getHeaderLine('Content-Type');
        if ($contentType) {
            return (bool) preg_match('/text\/html/i', $contentType);
        }

        return false;
    }

    /**
     * Checks whether the content type is plain text
     *
     * @return bool
     */
    public function isPlainText(): bool
    {
        $contentType = $this->getHeaderLine('Content-Type');
        if ($contentType) {
            return (bool) preg_match('/text\/plain/i', $contentType);
        }

        return false;
    }
}
