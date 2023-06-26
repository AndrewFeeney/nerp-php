<?php

use Nerp\TokenTypes\Identifier;

test('It matches a string of letters', function () {
    expect((new Identifier())->matches('asdf'))->toBeTrue();
});

test('It matches a dollar sign', function () {
    expect((new Identifier())->matches('$'))->toBeTrue();
});

test('It matches a string of letters which starts with a dollar sign', function () {
    expect((new Identifier())->matches('$asdf'))->toBeTrue();
});

test('it does not match an integer', function () {
    expect((new Identifier())->matches('100'))->toBeFalse();
});

test('It does not match whitespace', function () {
    expect((new Identifier())->matches(' '))->toBeFalse();
});