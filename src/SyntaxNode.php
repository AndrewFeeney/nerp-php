<?php

namespace Nerp;

interface SyntaxNode
{
    public function children(): array;

    public function hasChildren(): bool;

    public function evaluate(): mixed;
}
