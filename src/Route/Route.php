<?php

declare(strict_types=1);

namespace Furious\Router\Route;

use Furious\Router\Exception\InvalidArgumentException;
use Furious\Router\Exception\InvalidMethodException;
use Furious\Router\Http\Methods;
use Furious\Router\Match\RouteMatch;
use Furious\Router\Pattern\PatternReplacer;
use Psr\Http\Message\ServerRequestInterface;
use function in_array;

final class Route implements RouteInterface
{
    private string $name;
    private string $pattern;
    private string $action;
    private array $tokens;
    private array $methods;

    public function __construct(
        string $name, string $pattern, string $action,
        array $methods, array $tokens = []
    )
    {
        $this->name = $name;
        $this->pattern = $pattern;
        $this->action = $action;
        $this->tokens = $tokens;
        $this->validateMethods($methods);
        $this->methods = $methods;
    }

    public function generate(string $name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        /** @var string|null $url */
        $url = preg_replace_callback('~\{([^\}]+)\}~', function (array $matches) use (&$arguments) {
            $argument = $matches[1];
            if (!array_key_exists($argument, $arguments)) {
                throw new InvalidArgumentException('Missing parameter "' . $argument . '"');
            }
            return $arguments[$argument];
        }, $this->pattern);

        return $url;
    }

    public function match(ServerRequestInterface $request): ?RouteMatch
    {
        if (!$this->matchMethod($request->getMethod())) {
            return null;
        }

        $pattern = (new PatternReplacer())->replace($this->pattern);

        $path = $request->getUri()->getPath();

        if (!preg_match('~^' . $pattern . '$~i', $path, $matches)) {
            return null;
        }

        return new RouteMatch(
            $this->name,
            $this->action,
            array_filter(
                $matches, 'is_string',
                ARRAY_FILTER_USE_KEY
            )
        );
    }

    private function matchMethod(string $method): bool
    {
        return in_array($method, $this->methods, true);
    }

    private function validateMethods(array $methods): void
    {
        foreach ($methods as $method) {
            if (!in_array($method, Methods::LIST)) {
                throw new InvalidMethodException($method);
            }
        }
    }
}