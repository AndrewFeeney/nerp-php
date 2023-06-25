<?php

namespace Nerp\SyntaxNodeTypes;

use Nerp\SyntaxNode;
use Nerp\System;

class Integer implements SyntaxNode
{
    public function __construct(private int $value)
    {
    }

    public function children(): array
    {
        return [];
    }

    public function hasChildren(): bool
    {
        return false;
    }

    public function evaluate(System $system): mixed
    {
        return $this->value;
    }
}
