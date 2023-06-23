<?php

namespace Nerp;

use Nerp\NodeTypes\AddOperation;
use Nerp\NodeTypes\Integer;
use Nerp\NodeTypes\Message;

class Parser
{
    public function parse(TokenList $tokenList): ?SyntaxNode
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
        if ($secondToken->type === TokenType::EndOfFile) {
            return $this->parseToken($leftHandSide);
        }

        if (
            $leftHandSide->type === TokenType::Integer
            && $secondToken->type === TokenType::Operator
        ) {
            return $this->parseOperation($leftHandSide, $secondToken, $remainingTokens);
        }

        throw new \Exception('Unexpected token '.$leftHandSide->type->value.' value: "'.$leftHandSide->value.'"');
    }

    private function parseToken(Token $token): ?SyntaxNode
    {
        $syntaxNode = match($token->type) {
            TokenType::Integer => new Integer($token->value),
            TokenType::EndOfFile => null,
            default => throw new \Exception("Unable to parse token: ". $token->value),
        };

        return $syntaxNode;
    }

    private function parseOperation(Token $leftHandSide, Token $operator, TokenList $remainingTokens): SyntaxNode
    {
        return match($operator->value) {
            '+'         => new AddOperation($this->parseToken($leftHandSide), $this->parse($remainingTokens)),
            '.'        => $this->parseAttribute(name: $remainingTokens->shift()->value, previousToken: $leftHandSide, remainingTokens: $remainingTokens),
            default     => throw new \Exception('Invalid operation'),
        };
    }

    private function parseAttribute(string $name, Token $previousToken, TokenList $remainingTokens)
    {
        if (
            $remainingTokens->toArray()[0]->type === TokenType::Parenthesis
                && $remainingTokens->toArray()[0]->value === '('
                && $remainingTokens->toArray()[1]->type === TokenType::Parenthesis
                && $remainingTokens->toArray()[1]->value === ')'
        ) {
            return new Message(
                target: $this->parseToken($previousToken),
                name: $name,
            );
        }
    }
}
