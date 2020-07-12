<?php

declare(strict_types=1);

namespace Tests\Furious\Router;

use Furious\Psr7\ServerRequest;
use Furious\Router\Collection\RouteCollection;
use Furious\Router\Exception\InvalidArgumentException;
use Furious\Router\Exception\RequestNotMatchedException;
use Furious\Router\Exception\UnableToFoundRouteException;
use Furious\Router\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testSuccess(): void
    {
        $routes = new RouteCollection();

        $routes->get($nameGet = 'home', '/home', $handlerGet = 'Home');
        $routes->post($namePost = 'about', '/about', $handlerPost = 'About');

        $router = new Router($routes);

        $result = $router->match(new ServerRequest('GET', '/home'));
        $this->assertEquals($nameGet, $result->getRouteName());
        $this->assertEquals($handlerGet, $result->getAction());

        $result = $router->match(new ServerRequest('POST', '/about'));
        $this->assertEquals($namePost, $result->getRouteName());
        $this->assertEquals($handlerPost, $result->getAction());
    }

    public function testMissMethod(): void
    {
        $routes = new RouteCollection();

        $routes->post('home', '/home', 'Home');

        $router = new Router($routes);

        $this->expectException(RequestNotMatchedException::class);
        $router->match(new ServerRequest('PUT', '/home'));
    }

    public function testCorrectAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get($name = 'show', '/{id}', 'Action', ['id' => '\d+']);

        $router = new Router($routes);

        $result = $router->match(new ServerRequest('GET', '/5'));

        $this->assertEquals($name, $result->getRouteName());
        $this->assertEquals([
            'id' => '5'
        ], $result->getParams());
    }

    public function testIncorrectAttributes(): void
    {
        $routes = new RouteCollection();

        $routes->get($name = 'show', '/{id}', 'Action', ['id' => '\d+']);

        $router = new Router($routes);

        $this->expectException(RequestNotMatchedException::class);
        $router->match(new ServerRequest('GET', '/3ewfht'));
    }

    public function testGenerate(): void
    {
        $routes = new RouteCollection();

        $routes->get('home', '/home', 'Home');
        $routes->get('show', '/{id}', 'Action', ['id' => '\d+']);

        $router = new Router($routes);

        $this->assertEquals('/home', $router->generate('home'));
        $this->assertEquals('/5', $router->generate('show', ['id' => 5]));
    }

    public function testMissAttribute(): void
    {
        $routes = new RouteCollection();

        $routes->get($name = 'show', '/{id}', 'handler', ['id' => '\d+']);

        $router = new Router($routes);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing parameter "id"');
        $router->generate('show', ['egege' => 'g3gew']);
    }

    public function testNotFoundRoute(): void
    {
        $routes = new RouteCollection();
        $router = new Router($routes);

        $this->expectException(UnableToFoundRouteException::class);
        $this->expectExceptionMessage('Route "home" not found.');
        $router->generate('home');
    }
}