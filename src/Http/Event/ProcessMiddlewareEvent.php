<?php

/**
 *
 */
namespace Rmk\Http\Event;

use Psr\Http\Server\MiddlewareInterface;

/**
 * Class ProcessMiddlewareEvent
 * @package Rmk\Http\Event
 */
class ProcessMiddlewareEvent extends HttpEvent
{

    public function setMiddleware(MiddlewareInterface $middleware)
    {
        $this->setParam('middelware', $middleware);
    }
}
