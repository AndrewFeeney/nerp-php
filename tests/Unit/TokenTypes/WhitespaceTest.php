<?php

use Nerp\TokenTypes\Whitespace;

test('It matches a single whitespace', function () {
    expect((new Whitespace())->matches(' '))->toBeTrue();
});

test('It matches multiple whitespaces', function () {
    expect((new Whitespace())->matches('   '))->toBeTrue();
});

test('It matches a newline character', function () {
    expect((new Whitespace())->matches("\n"))->toBeTrue();
});

test('It does not match an empty string', function () {
    expect((new Whitespace())->matches(''))->toBeFalse();
});

test('It does not match a string containing digits', function () {
    expect((new Whitespace())->matches('1'))->toBeFalse();
});

test('It does not match a string containing alphabetical characters', function () {
    expect((new Whitespace())->matches('a'))->toBeFalse();
});

test('It does not match a string containing special characters', function () {
    expect((new Whitespace())->matches('$'))->toBeFalse();
});