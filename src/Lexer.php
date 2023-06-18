<?php

namespace Nerp;

class Lexer
{
    public function lex(string $input): TokenList
    {
        $tokenList = new TokenList([]);

        $chars = str_split($input);

        foreach ($chars as $char) {
            if (is_numeric($char)) {
                $tokenList->push(
                    new Token(
                        type: TokenType::Integer,
                        value: $char,
                    )
                );
            }
        }

        $tokenList->push(new Token(type: TokenType::EndOfFile));

        return $tokenList;
    }
}
