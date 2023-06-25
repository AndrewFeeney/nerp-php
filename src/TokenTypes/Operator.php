<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class Operator implements TokenType
{
    public function name(): string
    {
        return 'Operator';
    }

    public function matches(string $input): bool
    {
        return preg_match('/[+.]/', $input);
    }

    public function value(string $input): string
    {
        return $input;
    }
}
