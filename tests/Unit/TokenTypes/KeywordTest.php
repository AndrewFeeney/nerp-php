<?php

use Nerp\TokenTypes\Keyword;

test('It matches a string of letters', function () {
    expect((new Keyword())->matches('asdf'))->toBeTrue();
});

test('It matches a dollar sign', function () {
    expect((new Keyword())->matches('$'))->toBeTrue();
});

test('It matches a string of letters which starts with a dollar sign', function () {
    expect((new Keyword())->matches('$asdf'))->toBeTrue();
});

test('it does not match an integer', function () {
    expect((new keyword())->matches('100'))->tobefalse();
});

test('It does not match whitespace', function () {
    expect((new Keyword())->matches(' '))->toBeFalse();
});