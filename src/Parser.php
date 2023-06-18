<?php

namespace Nerp;

use Nerp\NodeTypes\Integer;

class Parser
{
    public function parse(TokenList $tokenList): SyntaxNode
    {
        $firstToken = $tokenList->first();

        if (is_null($firstToken)) {
            throw new \Exception('No nodes');
        }

        $parsed = $this->parseToken($firstToken);

        return $parsed;
    }

    private function parseToken(Token $token): SyntaxNode
    {
        $syntaxNode = match($token->type) {
            TokenType::Integer => new Integer($token->value),
            /* default => throw new \Exception("Unable to parse token: ". $token->value), */
        };

        return $syntaxNode;
    }
}
