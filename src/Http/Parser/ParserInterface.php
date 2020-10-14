<?php

namespace Rmk\Http\Parser;

use Rmk\Http\Exception\ParserException;

/**
 * Interface ParserInterface
 *
 * @package Rmk\Http\Parser
 */
interface ParserInterface
{

    /**
     * Parse the request content
     *
     * @param string $content
     *
     * @return mixed
     *
     * @throws ParserException
     */
    public function parse(string $content);
}
