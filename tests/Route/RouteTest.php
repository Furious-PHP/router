<?php

declare(strict_types=1);

namespace Tests\Furious\Router\Route;

use Furious\Psr7\ServerRequest;
use Furious\Router\Exception\InvalidArgumentException;
use Furious\Router\Exception\InvalidMethodException;
use Furious\Router\Match\RouteMatch;
use Furious\Router\Route\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testFound(): void
    {
        $serverRequest = new ServerRequest('GET', $path = '/');
        $route = new Route('home', $path, 'Action', ['GET']);

        $this->assertEquals($route->generate('home'), $path);
        $this->assertInstanceOf(RouteMatch::class, $route->match($serverRequest));
    }

    public function testCanNotGenerate(): void
    {
        $route = new Route('name', '/', 'Action', ['GET']);

        $this->assertNull($route->generate('some.other.name'));
    }

    public function testCanNotMatch(): void
    {
        $serverRequest = new ServerRequest('GET', '/');
        $route = new Route('home', '/some/other/url', 'Action', ['GET']);

        $this->assertNull($route->match($serverRequest));
    }

    public function testMissParameter(): void
    {
        $parameter = 'id';
        $route = new Route('home', "/{{$parameter}}", 'Action', ['GET']);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing parameter "' . $parameter . '"');
        $route->generate('home');
    }

    public function testGenerateWithParameters(): void
    {
        $route = new Route('home', '/{id}/{name}', 'Action', ['GET']);

        $this->assertEquals($route->generate('home', [
            'id' => 5,
            'name' => 'Pavel'
        ]), '/5/Pavel');
    }

    public function testNotFoundMethod(): void
    {
        $serverRequest = new ServerRequest('POST', '/');
        $route = new Route('home', '/', 'Action', ['GET']);

        $this->assertNull($route->match($serverRequest));
    }

    public function testInvalidMethod(): void
    {
        $this->expectException(InvalidMethodException::class);
        $this->expectExceptionMessage('Invalid method: ...');
        new Route('home', '/', 'Action', ['...']);
    }

    public function testMatchWithParameters(): void
    {
        $serverRequest = new ServerRequest('GET', '/5/Pavel');
        $route = new Route('home', '/{id}/{name}', 'Action', ['GET']);

        $this->assertInstanceOf(RouteMatch::class, $route->match($serverRequest));
    }

    public function testRouteMatch(): void
    {
        $params = [
            'id' => '5',
            'name' => 'Pavel'
        ];
        $serverRequest = new ServerRequest('GET', '/5/Pavel');
        $route = new Route($name = 'home', '/{id}/{name}', $action = 'Action', ['GET']);

        $this->assertInstanceOf(RouteMatch::class, $match = $route->match($serverRequest));
        $this->assertEquals($name, $match->getRouteName());
        $this->assertEquals($action, $match->getAction());
        $this->assertEquals($params, $match->getParams());
    }
}