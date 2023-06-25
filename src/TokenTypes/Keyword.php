<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class Keyword implements TokenType
{
    public function name(): string
    {
        return 'Keyword';
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