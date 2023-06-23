<?php

namespace Nerp\NodeTypes;

use Nerp\SyntaxNode;
use Nerp\System;

class Message implements SyntaxNode
{
    public function __construct(private string $name, private SyntaxNode $target)
    {
    }

    public function hasChildren(): bool
    {
        return true;
    }

    public function children(): array
    {
        return [$this->target];
    }

    public function evaluate(System $system): mixed
    {
        if ($this->name === 'print') {
            $system->print($this->target->evaluate($system));
        }

        return null;
    }
}
