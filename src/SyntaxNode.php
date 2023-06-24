<?php

namespace Nerp;

use Nerp\NodeTypes\Message;

interface SyntaxNode
{
    public function children(): array;

    public function hasChildren(): bool;

    public function evaluate(System $system): mixed;
}
