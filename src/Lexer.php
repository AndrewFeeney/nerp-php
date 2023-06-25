<?php

namespace Nerp;

use Nerp\TokenTypes\BadToken;
use Nerp\TokenTypes\EndOfFile;
use Nerp\TokenTypes\Integer;
use Nerp\TokenTypes\Keyword;
use Nerp\TokenTypes\Operator;
use Nerp\TokenTypes\Parenthesis;
use Nerp\TokenTypes\Whitespace;

class Lexer
{
    public function lex(string $input): TokenList
    {
        $tokenList = new TokenList([]);

        $chars = empty($input) ? [] : str_split($input);

        foreach ($chars as $char) {
            $tokenType = $this->getTokenType($char);
            $tokenList->push(
                new Token(
                    type: $tokenType,
                    value: $tokenType->value($char),
                )
            );    
        }

        $tokenList->push(new Token(type: new EndOfFile()));

        return $tokenList;
    }

    private function getTokenType(string $char): TokenType
    {
        foreach ([
            Whitespace::class,
            Integer::class,
            Operator::class,
            Keyword::class,
            Parenthesis::class,
        ] as $tokenTypeClass) {
            $tokenType = new $tokenTypeClass();

            if ($tokenType->matches($char)) {
                return $tokenType;
            }
        }

        return new BadToken();
    }
}
