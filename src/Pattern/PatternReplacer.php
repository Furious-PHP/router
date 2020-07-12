<?php

declare(strict_types=1);

namespace Furious\Router\Pattern;

final class PatternReplacer
{
    private const REGEXP = "#\{([^\}]+)\}#";

    public function replace(string $pattern): string
    {
        return preg_replace_callback(self::REGEXP, function ($matches) {
            $argument = $matches[1];
            $replace = $this->tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $pattern);
    }
}