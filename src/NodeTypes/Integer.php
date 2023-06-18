<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;

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

    public function evaluate(): mixed
    {
        return $this->value;
    }
}
