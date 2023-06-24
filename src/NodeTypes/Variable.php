<?php

namespace Nerp\NodeTypes;

use Nerp\Messageable;
use Nerp\SyntaxNode;
use Nerp\System;

class Variable implements SyntaxNode, Messageable
{
    private SyntaxNode $value;

    public function __construct(private string $name)
    {
    }

    public function hasChildren(): bool
    {
        return count($this->children());
    }

    public function children(): array
    {
        return isset($this->value) ? [$this->value] : [];
    }

    public function evaluate(System $system): mixed
    {
        if (!isset($this->value)) {
            return null;
        }

        return $this->value->evaluate($system);
    }

    public function sendMessage(System $system, Message $message): mixed
    {
        if ($this->name === '$system') {
            if ($message->name() === 'print') {
                if (!is_null($message->argument())) {
                    $output = $message->argument()->evaluate($system);
                } else {
                    $output = null;
                }

                $system->print($output);
            }
        }

        return null;
    }
}

