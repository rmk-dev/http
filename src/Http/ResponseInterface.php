<?php

/**
 * Response contract
 */
namespace Rmk\Http;

use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

/**
 * Interface ResponseInterface
 *
 * @package Rmk\Http
 */
interface ResponseInterface extends PsrResponseInterface, ContentPredicatesInterface
{

    /**
     * Checks whether the content type is HTML
     *
     * @return bool
     */
    public function isHtml(): bool;

    /**
     * Checks whether the content type is plain text
     *
     * @return bool
     */
    public function isPlainText(): bool;
}
