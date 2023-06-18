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

    public function isEmpty(): bool
    {
        return $this->length() === 0
            || $this->length() === 1 && $this->tokens[0]->type === TokenType::EndOfFile;
    }

    public function push(Token $token)
    {
        if ($this->length() === 0) {
            return $this->simplePush($token);
        }

        match ($token->type) {
            TokenType::Integer => $this->pushInteger($token),
            TokenType::Operator => $this->pushOperator($token),
            TokenType::Whitespace => $this->pushWhitespace($token),
            TokenType::Keyword => $this->pushKeyword($token),

            default => $this->simplePush($token),
        };
    }

    public function toArray(): array
    {
        return $this->tokens;
    }

    public function first(): Token|null
    {
        return $this->tokens[0] ?? null;
    }

    public function shift(): Token|null
    {
        do {
            $next = array_shift($this->tokens);
        } while ($next->type === TokenType::Whitespace);

        return $next;
    }

    private function pushKeyword(Token $token)
    {
        $lastToken = array_pop($this->tokens);

        if ($lastToken->type === TokenType::Keyword) {
            $token = new Token(type: TokenType::Keyword, value: $lastToken->value . $token->value);
        } else {
            $this->simplePush($lastToken);
        }

        $this->simplePush($token); 
    }

    private function pushWhitespace(Token $token)
    {
        $lastToken = array_pop($this->tokens);

        if ($lastToken->type === TokenType::Whitespace) {
            $token = new Token(type: TokenType::Whitespace);
        } else {
            $this->simplePush($lastToken);
        }

        $this->simplePush($token); 
    }

    private function pushOperator(Token $token)
    {
        $lastToken = array_pop($this->tokens);

        if ($this->operatorsCanBeCombined($lastToken, $token)) {
            $token = new Token(type: TokenType::Operator, value: $lastToken->value . $token->value);
        } else {
            $this->simplePush($lastToken);
        }

        $this->simplePush($token);
    }

    private function operatorsCanBeCombined(Token $a, Token $b)
    {
        return $a->value === '-' && $b->value === '>';
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
}
