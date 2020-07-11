<?php

declare(strict_types=1);

namespace Tests\Furious\Router;

use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testSuccess(): void
    {
        $this->assertEquals(1, 1);
    }
}