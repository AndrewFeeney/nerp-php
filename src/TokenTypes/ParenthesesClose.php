<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class ParenthesesClose implements TokenType
{
    public function name(): string
    {
        return 'Close Parentheses';
    }

    public function matches(string $input): bool
    {
        return $input === ')';
    }

    public function value(string $input): string
    {
        return $input;
    }
}