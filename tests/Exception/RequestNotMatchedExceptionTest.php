<?php

declare(strict_types=1);

namespace Furious\Router\Exception;

use Furious\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RequestNotMatchedExceptionTest extends TestCase
{
    public function testSuccess(): void
    {
        $request = new ServerRequest('GET', '/');
        $e = new RequestNotMatchedException($request);

        $this->assertEquals('Route matches not found', $e->getMessage());
        $this->assertEquals($request, $e->getRequest());
    }
}