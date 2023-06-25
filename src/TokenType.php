<?php

namespace Nerp;

interface TokenType
{
    public function name(): string;

    public function matches(string $input): bool;

    public function value(string $input): string;
}
