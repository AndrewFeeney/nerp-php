<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class Integer implements TokenType
{
    public function name(): string
    {
        return 'Integer';
    }

    public function matches(string $input): bool
    {
        return preg_match('/[0-9]+/', $input);
    }

    public function value(string $input): string
    {
        return $input;
    }
}
