<?php

use Nerp\NodeTypes\Integer;
use Nerp\Evaluator;

test('it_can_evaluate_an_integer', function () {
    $evaulator = new Evaluator();

    $ast = new Integer(123);

    $result = $evaulator->evaluate($ast);

    expect($result)->toEqual(123);
});
