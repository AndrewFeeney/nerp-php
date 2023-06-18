<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;

class Dictionary implements SyntaxNode
{
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
        
    }
}
