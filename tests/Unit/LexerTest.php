<?php

use Nerp\Lexer;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;

function expectTokensMatch(Token $tokenA, Token $tokenB) {
    expect($tokenB->type)->toEqual($tokenA->type);
    expect($tokenB->value)->toEqual($tokenA->value);
}

function expectTokenListsMatch(TokenList $tokenListA, TokenList $tokenListB) {
    expect($tokenListB->length())->toEqual($tokenListB->length());

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

test('it_can_lex_two_integers_separated_by_whitespace', function () {
    $lexer = new Lexer();

    expect($lexer->lex('123 4')->toArray())->toMatchArray([
        new Token(type: TokenType::Integer, value: '123'),
        new Token(type: TokenType::Whitespace, value: null),
        new Token(type: TokenType::Integer, value: '4'),
        new Token(type: TokenType::EndOfFile, value: null),
    ]);
});

test('it_can_lex_a_simple_add_expression', function () {
    $lexer = new Lexer();

    expect($lexer->lex('123 + 4')->toArray())->toMatchArray([
        new Token(type: TokenType::Integer, value: '123'),
        new Token(type: TokenType::Whitespace, value: null),
        new Token(type: TokenType::Operator, value: '+'),
        new Token(type: TokenType::Whitespace, value: null),
        new Token(type: TokenType::Integer, value: '4'),
        new Token(type: TokenType::EndOfFile, value: null),
    ]);
});

test('it_can_lex_an_object_operator', function () {
    $lexer = new Lexer();

    expect($lexer->lex('->')->toArray())->toMatchArray([
        new Token(type: TokenType::Operator, value: '->'),
    ]);
});
