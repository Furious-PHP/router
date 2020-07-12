<?php

declare(strict_types=1);

namespace Tests\Furious\Router\Collection;

use Furious\Router\Collection\RouteCollection;
use Furious\Router\Route\Route;
use PHPUnit\Framework\TestCase;

class RouteCollectionTest extends TestCase
{
    public function testAdd(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->add($route = new Route('name', '/', 'Action', ['GET']));
        $this->assertEquals(1, count($routeCollection->getRoutes()));
        $this->assertEquals($routeCollection->getRoutes()[0], $route);
    }

    public function testGet(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->get('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }

    public function testPost(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->post('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }

    public function testPut(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->put('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }

    public function testPatch(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->patch('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }

    public function testDelete(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->delete('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }

    public function testAny(): void
    {
        $routeCollection = new RouteCollection();
        $routeCollection->any('name', '/', 'Action');
        $this->assertEquals(1, count($routeCollection->getRoutes()));
    }
}