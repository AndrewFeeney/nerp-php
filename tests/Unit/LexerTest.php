<?php

use Nerp\Lexer;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;

function expectTokensMatch(Token $tokenA, Token $tokenB) {
    expect($tokenA->type)->toEqual($tokenB->type);
    expect($tokenB->value)->toEqual($tokenB->value);
}

function expectTokenListsMatch(TokenList $tokenListA, TokenList $tokenListB) {
    expect($tokenListA->length())->toEqual($tokenListB->length());

    foreach ($tokenListA->toArray() as $index => $tokenA) {
        expectTokensMatch($tokenA, $tokenListB->toArray()[$index]);
    }
}

test('it_can_lex_an_empty_string', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([new Token(type: TokenType::EndOfFile, value: null)]),
        $lexer->lex(''),
    );
});

test('it_treats_multiple_whitespace_characters_as_a_single_whitespace_token', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([
            new Token(type: TokenType::Whitespace, value: null),
            new Token(type: TokenType::EndOfFile, value: null),
        ]),
        $lexer->lex('   '),
    );
});

test('it_can_lex_whitespace', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([
            new Token(type: TokenType::Whitespace, value: null),
            new Token(type: TokenType::EndOfFile, value: null),
        ]),
        $lexer->lex(' '),
    );
});

test('it_can_lex_a_single_digit', function () {
    $lexer = new Lexer();

    expect($lexer->lex('1')->toArray())->toMatchArray([
        new Token(type: TokenType::Integer, value: '1'),
        new Token(type: TokenType::EndOfFile, value: null),
    ]);
});

test('it_can_lex_a_double_digit_integer', function () {
    $lexer = new Lexer();

    expect($lexer->lex('12')->toArray())->toMatchArray([
        new Token(type: TokenType::Integer, value: '12'),
        new Token(type: TokenType::EndOfFile, value: null),
    ]);
});

test('it_can_lex_a_quadruple_digit_integer', function () {
    $lexer = new Lexer();

    expect($lexer->lex('1234')->toArray())->toMatchArray([
        new Token(type: TokenType::Integer, value: '1234'),
        new Token(type: TokenType::EndOfFile, value: null),
    ]);
});
