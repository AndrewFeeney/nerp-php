<?php

use Nerp\Lexer;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;

test('it_can_lex_an_empty_string', function () {
    $lexer = new Lexer();

    expect($lexer->lex(''))->toEqual(new TokenList([
        new Token(type: TokenType::EndOfFile, value: null)
    ]));
});
