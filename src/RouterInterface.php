<?php

declare(strict_types=1);

namespace Furious\Router;

use Furious\Router\Exception\RequestNotMatchedException;
use Furious\Router\Exception\UnableToFoundRouteException;
use Furious\Router\Match\RouteMatch;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    /**
     * @param string $name
     * @param array $params
     * @throws UnableToFoundRouteException
     * @return string
     */
    public function generate(string $name, array $params): string;

    /**
     * @param ServerRequestInterface $request
     * @throws RequestNotMatchedException
     * @return RouteMatch
     */
    public function match(ServerRequestInterface $request): RouteMatch;
}