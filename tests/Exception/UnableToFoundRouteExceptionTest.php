<?php

declare(strict_types=1);

namespace Furious\Router\Exception;

use PHPUnit\Framework\TestCase;

class UnableToFoundRouteExceptionTest extends TestCase
{
    public function testSuccess(): void
    {
        $e = new UnableToFoundRouteException($name = 'home', $params = [
            'foo' => 'bar'
        ]);

        $this->assertEquals('Route "' . $name . '" not found.', $e->getMessage());
        $this->assertEquals($name, $e->getName());
        $this->assertEquals($params, $e->getParams());
    }
}