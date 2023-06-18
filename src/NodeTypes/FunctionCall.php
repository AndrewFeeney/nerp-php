<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;

class FunctionCall implements SyntaxNode
{
    public function __construct(private string $name, private SyntaxNode $argument)
    {
    }

    public function hasChildren(): bool
    {
        return true;
    }

    public function children(): array
    {
        return [$this->argument];
    }

    public function evaluate(): mixed
    {
        return null;
    }
}
