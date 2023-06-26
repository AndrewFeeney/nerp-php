<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class Identifier implements TokenType
{
    public function name(): string
    {
        return 'Identifier';
    }

    public function matches(string $input): bool
    {
        return preg_match('/^(\$)|(\$)?[a-zA-Z]+$/', $input);
    }

    public function value(string $input): string
    {
        return $input;
    }
}