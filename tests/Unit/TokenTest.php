<?php

use Nerp\Token;
use Nerp\TokenTypes\Whitespace;

test("It merges two whitespace characters", function () {
    $a = new Token(type: new Whitespace(), value: ' ');
    $b = new Token(type: new Whitespace(), value: ' ');

    $result = $a->merge($b);

    expect(count($result))->toEqual(1);
    expect($result[0]->type->name())->toBe('Whitespace');
    expect($result[0]->value)->toEqual('  ');
});

test("It merges a single whitespace character with a double whitespace character", function () {
    $a = new Token(type: new Whitespace(), value: '  ');
    $b = new Token(type: new Whitespace(), value: ' ');

    $result = $a->merge($b);

    expect(count($result))->toEqual(1);
    expect($result[0]->type->name())->toBe('Whitespace');
    expect($result[0]->value)->toEqual('   ');
});