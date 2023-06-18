<?php

namespace Nerp;

use Nerp\NodeTypes\AddOperation;
use Nerp\NodeTypes\Dictionary;
use Nerp\NodeTypes\FunctionCall;
use Nerp\NodeTypes\Integer;

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
            /* default => throw new \Exception("Unable to parse token: ". $token->value), */
        };

        return $syntaxNode;
    }

    private function parseOperation(Token $leftHandSide, Token $operator, TokenList $remainingTokens): SyntaxNode
    {
        return match($operator->value) {
            '+'         => new AddOperation($this->parseToken($leftHandSide), $this->parse($remainingTokens)),
            '->'        => $this->parseFunctionCall(name: $remainingTokens->shift()->value, primaryArgument: $leftHandSide, secondaryArgument: $remainingTokens),
            default     => throw new \Exception('Invalid operation'),
        };
    }

    private function parseFunctionCall(string $name, Token $primaryArgument, TokenList $secondaryArgument)
    {
        if ($secondaryArgument->isEmpty()) {
            return new FunctionCall($name, $this->parseToken($primaryArgument));
        }

        return new FunctionCall(
            $name,
            new Dictionary([
                'primaryArgument' => $primaryArgument,
                $this->parse($secondaryArgument),
            ])
        );
    }
}
