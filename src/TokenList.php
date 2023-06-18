<?php

namespace Nerp;

class TokenList
{
    public function __construct(private array $tokens)
    {
        
    }

    public function length(): int
    {
        return count($this->tokens);
    }

    public function push(Token $token)
    {
        array_push($this->tokens, $token);
    }

    public function toArray(): array
    {
        return $this->tokens;
    }
}
