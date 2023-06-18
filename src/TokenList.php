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
        if ($this->length() === 0) {
            return $this->simplePush($token);
        }

        match ($token->type) {
            TokenType::Integer => $this->pushInteger($token),
            default => $this->simplePush($token),
        };
    }

    private function simplePush(Token $token)
    {
        array_push($this->tokens, $token);
    }

    private function pushInteger(Token $token)
    {
        $lastToken = array_pop($this->tokens);

        if ($lastToken->type === TokenType::Integer) {
            $token = new Token(type: TokenType::Integer, value: $lastToken->value . $token->value);
        } else {
            $this->simplePush($lastToken);
        }

        $this->simplePush($token);
    }

    public function toArray(): array
    {
        return $this->tokens;
    }
}
