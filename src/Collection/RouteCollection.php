<?php

declare(strict_types=1);

namespace Furious\Router\Collection;

use Furious\Router\Route\Route;
use Furious\Router\Route\RouteInterface;

final class RouteCollection
{
    private array $routes = [];

    public function add(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function get(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, ['GET'], $tokens));
    }

    public function post(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, ['POST'], $tokens));
    }

    public function put(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, ['PUT'], $tokens));
    }

    public function patch(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, ['PATCH'], $tokens));
    }

    public function delete(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, ['DELETE'], $tokens));
    }

    public function any(string $name, string $pattern, string $action, array $tokens = []): void
    {
        $this->add(new Route($name, $pattern, $action, [], $tokens));
    }

    /**
     * @return array|RouteInterface[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}