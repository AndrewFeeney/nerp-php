<?php

namespace Nerp;

class Lexer
{
    public function lex(string $input): TokenList
    {
        $tokenList = new TokenList([]);

        $chars = empty($input) ? [] : str_split($input);

        foreach ($chars as $char) {
            $tokenType = $this->getTokenType($char);
            $tokenValue = $this->getTokenValue($tokenType, $char);
            $tokenList->push(
                new Token(
                    type: $tokenType,
                    value: $tokenValue,
                )
            );    
        }

        $tokenList->push(new Token(type: TokenType::EndOfFile));

        return $tokenList;
    }

    private function getTokenType(string $char): TokenType
    {
        if ($this->isWhitespace($char)) {
            return TokenType::Whitespace;
        }

        if (is_numeric($char)) {
            return TokenType::Integer;
        }

        if ($this->isOperator($char)) {
            return TokenType::Operator;
        }

        if (ctype_alpha($char)) {
            return TokenType::Keyword;
        }

        return TokenType::BadToken;
    }

    private function getTokenValue(TokenType $type, string $char): string|null
    {
        return match ($type) {
            TokenType::Whitespace => null,
            TokenType::EndOfFile => null,
            default => $char,
        };
    }

    private function isOperator(string $char): bool
    {
        return in_array($char, ['+', '-', '>']);
    }

    private function isWhitespace(string $str): bool
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
