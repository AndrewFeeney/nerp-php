<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class Whitespace implements TokenType
{
    public function name(): string
    {
        return 'Whitespace';
    }

    public function matches(string $input): bool
    {
        return preg_match('/^\s+$/', $input);
    }

    public function value(string $input): string
    {
        return $input;
    }
}