<?php

namespace Nerp\NodeTypes;

use Nerp\Messageable;
use Nerp\SyntaxNode;
use Nerp\System;

class Message implements SyntaxNode
{
    public function __construct(
        private string $name,
        private SyntaxNode $target,
        private SyntaxNode|null $argument = null
    )
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
        if ($this->target instanceof Messageable) {
            return $this->target->sendMessage($system, $this);
        }

        throw new \Exception('Cannot send message to target of type: '.get_class($this->target));
    }

    public function name(): string
    {
        return $this->name;
    }

    public function argument(): SyntaxNode|null
    {
        return $this->argument;
    }
}
