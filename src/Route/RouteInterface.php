<?php

declare(strict_types=1);

namespace Furious\Router\Route;

use Furious\Router\Match\RouteMatch;
use Psr\Http\Message\ServerRequestInterface;

interface RouteInterface
{
    public function generate(string $name, array $params = []): ?string;

    public function match(ServerRequestInterface $request): ?RouteMatch;
}