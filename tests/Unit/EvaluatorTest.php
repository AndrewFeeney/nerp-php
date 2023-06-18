<?php

use Nerp\NodeTypes\Integer;
use Nerp\Evaluator;
use Nerp\NodeTypes\AddOperation;

test('it_can_evaluate_an_integer', function () {
    $evaulator = new Evaluator();

    $ast = new Integer(123);

    $result = $evaulator->evaluate($ast);

    expect($result)->toEqual(123);
});

test('it_can_evaluate_a_simple_addition', function () {
    $evaulator = new Evaluator();

    $ast = new AddOperation(
        new Integer(1),
        new Integer(2),
    );

    $result = $evaulator->evaluate($ast);

    expect($result)->toEqual(3);
});

test('it_can_evaluate_a_nested_addition', function () {
    $evaulator = new Evaluator();

    $ast = new AddOperation(
        new Integer(1),
        new AddOperation(
            new Integer(2),
            new Integer(3),
        )
    );

    $result = $evaulator->evaluate($ast);

    expect($result)->toEqual(6);
});
