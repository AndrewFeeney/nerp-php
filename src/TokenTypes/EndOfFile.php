<?php

namespace Nerp\TokenTypes;

use Nerp\TokenType;

class EndOfFile implements TokenType
{
    public function name(): string
    {
        return 'End of File';   
    }

    public function matches(string $input): bool
    {
        return false;
    }

    public function value(string $input): string
    {
        return '';
    }
}