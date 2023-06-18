<?php

namespace Nerp;

class Lexer
{
    public function lex(string $input): TokenList
    {
        return new TokenList([
            new Token(
                type: TokenType::EndOfFile,
            )
        ]);
    }
}
