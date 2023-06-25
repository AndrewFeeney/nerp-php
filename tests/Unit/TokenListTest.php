<?php

use Nerp\Token;
use Nerp\TokenList;
use Nerp\TokenTypes\Whitespace;

test('It can push a whitespace on to a list with an existing whitespace token, merging them', function () {
    $tokenList = new TokenList([]);
    $firstWhitespaceToken = new Token(type: new Whitespace(), value: ' ');
    $secondWhitespaceToken = new Token(type: new Whitespace(), value: ' ');

    $tokenList->push($firstWhitespaceToken);

    expect($tokenList->length())->toEqual(1);
    expect($tokenList->first()->value)->toEqual(' ');

    $tokenList->push($secondWhitespaceToken);

    expect($tokenList->length())->toEqual(1);
    expect($tokenList->first()->value)->toEqual('  ');
});