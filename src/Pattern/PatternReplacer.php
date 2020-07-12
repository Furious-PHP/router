<?php

declare(strict_types=1);

namespace Furious\Router\Pattern;

final class PatternReplacer
{
    private const REGEXP = "#\{([^\}]+)\}#";

    public function replace(string $pattern, array $tokens): string
    {
        return preg_replace_callback(self::REGEXP, function ($matches) use ($tokens) {
            $argument = $matches[1];
            $replace = $tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $pattern);
    }
}