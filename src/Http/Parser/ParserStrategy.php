<?php

namespace Rmk\Http\Parser;

use Rmk\Http\Exception\ParserException;
use Rmk\Http\ServerRequestInterface;

class ParserStrategy
{

    public const JSON_PARSER_KEY = 'json';

    public const XML_PARSER_KEY = 'xml';

    public const FORM_PARSER_KEY = 'form';

    /**
     * @var array
     */
    protected array $parsers = [];

    /**
     * ParserStrategy constructor.
     * @param array $parsers
     */
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    public function getParser(ServerRequestInterface $request): ?ParserInterface
    {
        $parser = null;
        if (array_key_exists(self::XML_PARSER_KEY, $this->parsers) && $request->isXml()) {
            $parser = $this->parsers[self::XML_PARSER_KEY];
        } elseif (array_key_exists(self::JSON_PARSER_KEY, $this->parsers) && $request->isJson()) {
            $parser = $this->parsers[self::JSON_PARSER_KEY];
        } elseif (array_key_exists(self::FORM_PARSER_KEY, $this->parsers) && $request->isUrlFormEncoded()) {
            $parser = $this->parsers[self::FORM_PARSER_KEY];
        }

        if ($parser && !($parser instanceof ParserInterface)) {
            throw new ParserException('Invalid parser', ParserException::INVALID_PARSER);
        }

        return $parser;
    }
}
