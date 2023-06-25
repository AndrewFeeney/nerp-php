<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class BadToken implements TokenType
{
    public function name(): string
    {
        return 'Bad Token';
    }

    public function matches(string $input): bool
    {
        return true;
    }

    public function value(string $input): string
    {
        return $input;
    }
}