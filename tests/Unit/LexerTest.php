<?php

use Nerp\Lexer;
use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenType;
use Nerp\TokenTypes\EndOfFile;
use Nerp\TokenTypes\Integer;
use Nerp\TokenTypes\Keyword;
use Nerp\TokenTypes\Operator;
use Nerp\TokenTypes\Parenthesis;
use Nerp\TokenTypes\Whitespace;

function expectTokensMatch(Token $tokenA, Token $tokenB) {
    $tokenAType = $tokenA->type->name();
    $tokenBType = $tokenB->type->name();

    expect($tokenBType)
        ->toEqual(
            $tokenAType,
            "Failed asserting that two tokens have the same type: expected $tokenAType \"$tokenA->value\" received $tokenBType \"$tokenB->value\""
        );

    expect($tokenB->value)->toEqual($tokenA->value);
}

function expectTokenListsMatch(TokenList $tokenListA, TokenList $tokenListB) {
    expect($tokenListB->length())->toEqual($tokenListA->length());

    foreach ($tokenListA->toArray() as $index => $tokenA) {
        expectTokensMatch($tokenA, $tokenListB->toArray()[$index]);
    }
}

test('it_can_lex_an_empty_string', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([new Token(type: new EndOfFile(), value: null)]),
        $lexer->lex(''),
    );
});

test('it_treats_multiple_whitespace_characters_as_a_single_whitespace_token', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([
            new Token(type: new Whitespace(), value: '   '),
            new Token(type: new EndOfFile(), value: ''),
        ]),
        $lexer->lex('   '),
    );
});

test('it_can_lex_whitespace', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        new TokenList([
            new Token(type: new Whitespace(), value: ' '),
            new Token(type: new EndOfFile(), value: null),
        ]),
        $lexer->lex(' '),
    );
});

test('it_can_lex_a_single_digit', function () {
    $lexer = new Lexer();

    expect($lexer->lex('1')->toArray())->toMatchArray([
        new Token(type: new Integer(), value: '1'),
        new Token(type: new EndOfFile(), value: null),
    ]);
});

test('it_can_lex_a_double_digit_integer', function () {
    $lexer = new Lexer();

    expect($lexer->lex('12')->toArray())->toMatchArray([
        new Token(type: new Integer(), value: '12'),
        new Token(type: new EndOfFile(), value: null),
    ]);
});

test('it_can_lex_a_quadruple_digit_integer', function () {
    $lexer = new Lexer();

    expect($lexer->lex('1234')->toArray())->toMatchArray([
        new Token(type: new Integer(), value: '1234'),
        new Token(type: new EndOfFile(), value: null),
    ]);
});

test('it_can_lex_two_integers_separated_by_whitespace', function () {
    $lexer = new Lexer();

    expect($lexer->lex('123 4')->toArray())->toMatchArray([
        new Token(type: new Integer(), value: '123'),
        new Token(type: new Whitespace(), value: ' '),
        new Token(type: new Integer(), value: '4'),
        new Token(type: new EndOfFile(), value: null),
    ]);
});

test('it_can_lex_a_simple_add_expression', function () {
    $lexer = new Lexer();

    expect($lexer->lex('123 + 4')->toArray())->toMatchArray([
        new Token(type: new Integer(), value: '123'),
        new Token(type: new Whitespace(), value: ' '),
        new Token(type: new Operator(), value: '+'),
        new Token(type: new Whitespace(), value: ' '),
        new Token(type: new Integer(), value: '4'),
        new Token(type: new EndOfFile(), value: null),
    ]);
});

test('it_can_lex_an_object_operator', function () {
    $lexer = new Lexer();

    expect($lexer->lex('.')->toArray())->toMatchArray([
        new Token(type: new Operator(), value: '.'),
    ]);
});

test('it_can_lex_a_keyword_operator', function () {
    $lexer = new Lexer();

    expect($lexer->lex('print')->toArray())->toMatchArray([
        new Token(type: new Keyword(), value: 'print'),
    ]);
});

test('it_can_lex_a_system_print_call_with_an_integer_as_a_parameter', function () {
    $lexer = new Lexer();

    expectTokenListsMatch(
        (new TokenList([
            new Token(type: new Keyword(), value: '$system'),
            new Token(type: new Operator(), value: '.'),
            new Token(type: new Keyword(), value: 'print'),
            new Token(type: new Parenthesis(), value: '('),
            new Token(type: new Integer(), value: '123'),
            new Token(type: new Parenthesis(), value: ')'),
            new Token(type: new EndOfFile(), value: null),
        ])),
        $lexer->lex('$system.print(123)')
    );
});
