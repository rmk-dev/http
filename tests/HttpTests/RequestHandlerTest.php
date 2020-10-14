<?php

namespace Rmk\HttpTests;

use Ds\Queue;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Rmk\CallbackResolver\CallbackResolver;
use Rmk\Container\Container;
use Rmk\Event\EventDispatcher;
use Rmk\Event\ListenerProvider;
use Rmk\Http\Event\HandleRequestEvent;
use Rmk\Http\Event\ProcessMiddlewareEvent;
use Rmk\Http\Factory\ServerRequestFactory;
use Rmk\Http\RequestHandler;
use Rmk\Http\Response;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rmk\Router\Route;

use function GuzzleHttp\Psr7\stream_for;

class TestMiddleware implements MiddlewareInterface
{
    public static $counter = 0;
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        self::$counter++;
        return $handler->handle($request->withAttribute('counter', self::$counter));
    }
}
/**
 * Class RequestHandlerTest
 * @package Rmk\HttpTests
 */
class RequestHandlerTest extends TestCase
{

    protected $handler;
    private $middlewares;
    private $response;

    protected function setUp(): void
    {
        $this->response = new Response();
        $container = new Container();
        $listenerProvider = new ListenerProvider(new CallbackResolver($container));
        $listenerProvider->addListener(static function (ProcessMiddlewareEvent $event) {
            $response = $event->getResponse();
            $event->setResponse($response->withStatus(400));
        });
        $listenerProvider->addListener(static function (ProcessMiddlewareEvent $event) {
            $request = $event->getRequest();
            $event->setRequest($request->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett'));
        });
        $listenerProvider->addListener(function (HandleRequestEvent $event) {
            $request = $event->getRequest();
            $this->assertTrue($request->hasHeader('X-Clacks-Overhead'));
            $this->assertEquals('GNU Terry Pratchett', $request->getHeaderLine('X-Clacks-Overhead'));
            $this->assertEquals(TestMiddleware::$counter, $request->getAttribute('counter'), 'Counter is not set');
            $response = $event->getResponse();
            $event->setResponse($response->withHeader('X-Clacks-Overhead', 'GNU Terry Pratchett'));
        });
        $eventDispatcher = new EventDispatcher($listenerProvider);
        $this->middlewares = new Queue([new TestMiddleware(), new TestMiddleware()]);
        $route = $this->createMock(Route::class);
        $this->handler = new RequestHandler($this->response, $eventDispatcher, $this->middlewares, $route);
    }

    public function testGettersSetters()
    {
        $this->handler->addMiddleware(new TestMiddleware());
        $this->assertSame($this->middlewares, $this->handler->getMiddlewares());
        $this->assertSame($this->response, $this->handler->getResponse());
        $this->assertTrue($this->handler->hasMiddleware($this->middlewares->peek()));
    }

    public function testMiddlewares()
    {
        $factory = new ServerRequestFactory();
        $request = $factory->createServerRequest('GET', 'https://example.com');
        $response = $this->handler->handle($request);
        $this->assertEquals(0, $this->middlewares->count());
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('X-Clacks-Overhead'));
        $this->assertEquals('GNU Terry Pratchett', $response->getHeaderLine('X-Clacks-Overhead'));
    }

    public function testMiddlewaresChangeResponseBody()
    {
        $beforeMiddleware = new class implements MiddlewareInterface {
            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();
                return (new Response())->withBody(stream_for('BEFORE CONTENT ' . $existingContent));
            }
        };
        $afterMiddleware = new class implements MiddlewareInterface {
            public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
            {
                $response = $handler->handle($request);
                $response->getBody()->write(' AFTER CONTENT');
                return $response;
            }
        };
        $this->middlewares->push($beforeMiddleware, $afterMiddleware);
        $factory = new ServerRequestFactory();
        $request = $factory->createServerRequest('GET', 'https://example.com');
        $response = $this->handler->handle($request);
        $body = $response->getBody()->__toString();
        $this->assertStringStartsWith('BEFORE CONTENT ', $body);
        $this->assertStringEndsWith(' AFTER CONTENT', $body);
    }
}
