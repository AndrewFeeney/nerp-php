<?php

namespace Nerp;

use Nerp\SyntaxNodeTypes\AddOperation;
use Nerp\SyntaxNodeTypes\Integer;
use Nerp\SyntaxNodeTypes\Message;
use Nerp\SyntaxNodeTypes\SubtractOperation;
use Nerp\SyntaxNodeTypes\Variable;
use Nerp\TokenTypes\EndOfFile;
use Nerp\TokenTypes\ParenthesesOpen;
use Nerp\TokenTypes\ParenthesesClose;
use Nerp\TokenTypes\Integer as IntegerTokenType;
use Nerp\TokenTypes\Identifier;
use Nerp\TokenTypes\Operator;

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
        if (get_class($secondToken->type) === EndOfFile::class) {
            return $this->parseToken($leftHandSide);
        }

        if (
            in_array(get_class($leftHandSide->type), [
                IntegerTokenType::class,
                Identifier::class,
            ]) && get_class($secondToken->type) === Operator::class
        ) {
            return $this->parseOperation($leftHandSide, $secondToken, $remainingTokens);
        }

        throw new \Exception('Unexpected token '.$leftHandSide->type->name().' with value: "'.$leftHandSide->value.'"');
    }

    private function parseToken(Token $token): ?SyntaxNode
    {
        $syntaxNode = match(get_class($token->type)) {
            IntegerTokenType::class => new Integer($token->value),
            Identifier::class => new Variable($token->value),
            EndOfFile::class => null,
            default => throw new \Exception("Unable to parse token: ". $token->value),
        };

        return $syntaxNode;
    }

    private function parseOperation(Token $leftHandSide, Token $operator, TokenList $remainingTokens): SyntaxNode
    {
        return match($operator->value) {
            '+'         => new AddOperation($this->parseToken($leftHandSide), $this->parse($remainingTokens)),
            '-'         => new SubtractOperation($this->parseToken($leftHandSide), $this->parse($remainingTokens)),
            '.'        => $this->parseAttribute(name: $remainingTokens->shift()->value, previousToken: $leftHandSide, remainingTokens: $remainingTokens),
            default     => throw new \Exception('Invalid operation'),
        };
    }

    private function parseAttribute(string $name, Token $previousToken, TokenList $remainingTokens)
    {
        // Method call with no argument
        if (
            get_class($remainingTokens->toArray()[0]->type) === ParenthesesOpen::class
                && get_class($remainingTokens->toArray()[1]->type) === ParenthesesClose::class
        ) {
            return new Message(
                target: $this->parseToken($previousToken),
                name: $name,
            );
        }

        // Method call with argument
        if (
            get_class($remainingTokens->toArray()[0]->type) === ParenthesesOpen::class
                && get_class($remainingTokens->toArray()[1]->type) === IntegerTokenType::class
                && get_class($remainingTokens->toArray()[2]->type) === ParenthesesClose::class
        ) {
            return new Message(
                target: $this->parseToken($previousToken),
                argument: $this->parseToken($remainingTokens->toArray()[1]),
                name: $name,
            );
        }

        throw new \Exception("Unable to parse attribute: \"$name\"");
    }
}
