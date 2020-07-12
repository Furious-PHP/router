<?php

declare(strict_types=1);

namespace Furious\Router;

use Furious\Router\Collection\RouteCollection;
use Furious\Router\Exception\RequestNotMatchedException;
use Furious\Router\Exception\UnableToFoundRouteException;
use Furious\Router\Match\RouteMatch;
use Psr\Http\Message\ServerRequestInterface;

class Router implements RouterInterface
{
    private RouteCollection $routes;

    /**
     * Router constructor.
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
    }

    public function generate(string $name, array $params = []): string
    {
        $routes = $this->routes->getRoutes();

        foreach ($routes as $route) {
            $url = $route->generate($name, array_filter($params));
            if (null !== $url) {
                return $url;
            }
        }

        throw new UnableToFoundRouteException($name, $params);
    }

    public function match(ServerRequestInterface $request): RouteMatch
    {
        $routes = $this->routes->getRoutes();

        foreach ($routes as $route) {
            if ($result = $route->match($request)) {
                return $result;
            }
        }

        throw new RequestNotMatchedException($request);
    }
}