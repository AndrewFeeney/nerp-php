<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class ParenthesesOpen implements TokenType
{
    public function name(): string
    {
        return 'Open Parentheses';
    }

    public function matches(string $input): bool
    {
        return $input === '(';
    }

    public function value(string $input): string
    {
        return $input;
    }
}