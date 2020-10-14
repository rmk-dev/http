<?php

namespace Rmk\Http\Event;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rmk\Event\EventInterface;
use Rmk\Event\Traits\EventTrait;
use Rmk\Router\Route;

/**
 * Class HttpEvent
 *
 * @package Rmk\Http\Event
 */
class HttpEvent implements EventInterface
{
    use EventTrait;

    public function setRequest(ServerRequestInterface $serverRequest)
    {
        $this->setParam('request', $serverRequest);
    }

    public function getRequest(): ServerRequestInterface
    {
        return $this->getParam('request');
    }

    public function setResponse(ResponseInterface $response)
    {
        $this->setParam('response', $response);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->getParam('response');
    }

    public function setMatchedRoute(Route $route)
    {
        $this->setParam('matched_route', $route);
    }

    public function getMatchedRoute(): Route
    {
        return $this->getParam('matched_route');
    }
}
