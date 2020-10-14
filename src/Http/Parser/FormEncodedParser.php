<?php

namespace Rmk\Http\Parser;

/**
 * Class FormEncodedParser
 * @package Rmk\Http\Parser
 */
class FormEncodedParser implements ParserInterface
{

    public function parse(string $content)
    {
        $data = [];
        parse_str($content, $data);

        return $data;
    }
}
