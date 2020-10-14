<?php

/**
 *
 */

namespace Rmk\Http;

use Ds\Queue;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Rmk\Http\Event\HandleRequestEvent;
use Rmk\Http\Event\ProcessMiddlewareEvent;
use Rmk\Router\Route;

class RequestHandler implements RequestHandlerInterface
{

    /**
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @var EventDispatcherInterface
     */
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * @var Queue
     */
    protected Queue $middlewares;

    /**
     * @var Route
     */
    protected Route $matchedRoute;

    /**
     * RequestHandler constructor.
     *
     * @param ResponseInterface $response
     * @param EventDispatcherInterface $eventDispatcher
     * @param Queue $middlewares
     * @param Route $matchedRoute
     */
    public function __construct(
        ResponseInterface $response,
        EventDispatcherInterface $eventDispatcher,
        Queue $middlewares,
        Route $matchedRoute
    ) {
        $this->response = $response;
        $this->eventDispatcher = $eventDispatcher;
        $this->middlewares = $middlewares;
        $this->matchedRoute = $matchedRoute;
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return $this
     */
    public function addMiddleware(MiddlewareInterface $middleware): RequestHandler
    {
        $this->middlewares->push($middleware);

        return $this;
    }

    /**
     * @param MiddlewareInterface $middleware
     *
     * @return bool
     */
    public function hasMiddleware(MiddlewareInterface $middleware): bool
    {
        return in_array($middleware, $this->middlewares->toArray(), true);
    }


    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->middlewares->isEmpty()) {
            $this->handleRequest($request);
        } else {
            $this->processMiddlewares($request);
        }

        return $this->response;
    }

    /**
     * @return Queue
     */
    public function getMiddlewares(): Queue
    {
        return $this->middlewares;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ServerRequestInterface $request
     */
    protected function processMiddlewares(ServerRequestInterface $request): void
    {
        /** @var MiddlewareInterface $middleware */
        $middleware = $this->middlewares->pop();
        $middlewareEvent = new ProcessMiddlewareEvent($this);
        $middlewareEvent->setResponse($this->response);
        $middlewareEvent->setRequest($request);
        $middlewareEvent->setMiddleware($middleware);
        $middlewareEvent->setMatchedRoute($this->matchedRoute);
        $this->eventDispatcher->dispatch($middlewareEvent);
        $this->response = $middlewareEvent->getResponse();
        $request = $middlewareEvent->getRequest();
        $this->matchedRoute = $middlewareEvent->getMatchedRoute();
        $this->response = $middleware->process($request, $this);
    }

    /**
     * @param ServerRequestInterface $request
     */
    protected function handleRequest(ServerRequestInterface $request): void
    {
        $handleEvent = new HandleRequestEvent($this);
        $handleEvent->setRequest($request);
        $handleEvent->setResponse($this->response);
        $handleEvent->setMatchedRoute($this->matchedRoute);
        $this->eventDispatcher->dispatch($handleEvent);
        $this->matchedRoute = $handleEvent->getMatchedRoute();
        $this->response = $handleEvent->getResponse();
    }
}
