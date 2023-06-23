<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;
use Nerp\System;

class AddOperation implements SyntaxNode
{
    public function __construct(private SyntaxNode $leftHandSide, private SyntaxNode $rightHandSide)
    {
    }

    public function hasChildren(): bool
    {
        return true;
    }

    public function children(): array
    {
        return [
            $this->leftHandSide,
            $this->rightHandSide,
        ];   
    }

    public function evaluate(System $system): mixed
    {
        return $this->leftHandSide->evaluate($system) + $this->rightHandSide->evaluate($system);
    }
}
