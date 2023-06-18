<?php

namespace Nerp;

class Lexer
{
    public function lex(string $input): TokenList
    {
        $tokenList = new TokenList([]);

        $chars = str_split($input);

        foreach ($chars as $char) {
            if ($this->isWhitespace($char)) {
                $tokenList->push(new Token(type: TokenType::Whitespace));
            } else {
                if (is_numeric($char)) {
                    $tokenList->push(
                        new Token(
                            type: TokenType::Integer,
                            value: $char,
                        )
                    );
                }
            }
        }

        $tokenList->push(new Token(type: TokenType::EndOfFile));

        return $tokenList;
    }

    public function isWhitespace(string $str): bool
    {
        if (mb_strlen($str) === 0) {
            return false;
        }

        // Remove all whitespace characters from the string
        $strWithoutWhitespace = preg_replace('/\s+/', '', $str);

        // If the resulting string is empty, it means the original string
        // contained only whitespace characters
        return empty($strWithoutWhitespace);
    }
}
