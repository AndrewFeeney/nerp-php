<?php

namespace Nerp;

use Nerp\TokenTypes\EndOfFile;

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
            || $this->length() === 1 && get_class($this->tokens[0]->type) === EndOfFile::class;
    }

    public function push(Token $token)
    {
        if ($this->length() === 0) {
            return $this->simplePush($token);
        }

        $lastToken = array_pop($this->tokens);

        $nextTokens = $token->merge($lastToken);

        foreach ($nextTokens as $nextToken) {
            $this->simplePush($nextToken);
        }
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
        } while (get_class($next->type) === Whitespace::class);

        return $next;
    }

    private function simplePush(Token $token)
    {
        array_push($this->tokens, $token);
    }
}
