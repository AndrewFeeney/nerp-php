<?php

use Nerp\SyntaxNodeTypes\Integer;
use Nerp\Evaluator;
use Nerp\SyntaxNodeTypes\AddOperation;
use Nerp\System;

test('it_can_evaluate_an_integer', function () {
    $evaluator = new Evaluator(new System());

    $ast = new Integer(123);

    $result = $evaluator->evaluate($ast);

    expect($result)->toEqual(123);
});

test('it_can_evaluate_a_simple_addition', function () {
    $evaluator = new Evaluator(new System());

    $ast = new AddOperation(
        new Integer(1),
        new Integer(2),
    );

    $result = $evaluator->evaluate($ast);

    expect($result)->toEqual(3);
});

test('it_can_evaluate_a_nested_addition', function () {
    $evaluator = new Evaluator(new System());

    $ast = new AddOperation(
        new Integer(1),
        new AddOperation(
            new Integer(2),
            new Integer(3),
        )
    );

    $result = $evaluator->evaluate($ast);

    expect($result)->toEqual(6);
});
