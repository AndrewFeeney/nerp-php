<?php

namespace Nerp;

use Nerp\NodeTypes\AddOperation;
use Nerp\NodeTypes\Integer;

class Parser
{
    public function parse(TokenList $tokenList): SyntaxNode
    {
        if ($tokenList->length() === 0) {
            throw new \Exception('No nodes');
        }

        if ($tokenList->length() === 1) {
            return $this->parseToken($tokenList->first());
        }

        $firstToken = $tokenList->shift();

        return $this->parseExpression($firstToken, $tokenList);
    }

    private function parseExpression(Token $leftHandSide, TokenList $remainingTokens): SyntaxNode
    {
        $secondToken = $remainingTokens->shift();

        if (
            $leftHandSide->type === TokenType::Integer
            && $secondToken->type === TokenType::Operator
        ) {
            return $this->parseOperation($leftHandSide, $secondToken, $remainingTokens);
        }

        throw new \Exception('Unexpected token '.$leftHandSide->type->value.' value: "'.$leftHandSide->value.'"');
    }

    private function parseToken(Token $token): SyntaxNode
    {
        $syntaxNode = match($token->type) {
            TokenType::Integer => new Integer($token->value),
            /* default => throw new \Exception("Unable to parse token: ". $token->value), */
        };

        return $syntaxNode;
    }

    private function parseOperation(Token $leftHandSide, Token $operator, TokenList $remainingTokens): SyntaxNode
    {
        return match($operator->value) {
            '+' => new AddOperation($this->parseToken($leftHandSide), $this->parse($remainingTokens)),
            default => throw new \Exception('Invalid operation'),
        };
    }
}
