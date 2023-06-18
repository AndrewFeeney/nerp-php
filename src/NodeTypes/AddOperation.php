<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;

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

    public function evaluate(): mixed
    {
        return $this->leftHandSide->evaluate() + $this->rightHandSide->evaluate();
    }
}
