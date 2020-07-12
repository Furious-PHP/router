<?php

declare(strict_types=1);

namespace Furious\Router\Exception;

use InvalidArgumentException;
use Throwable;

class InvalidMethodException extends InvalidArgumentException
{
    public function __construct(string $method, string $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        if ('' === $message) {
            $this->message = 'Invalid method: ' . $method;
        }
    }
}