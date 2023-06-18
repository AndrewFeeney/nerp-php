<?php

use Nerp\Interpreter;

test('it_can_interpret_an_integer', function () {
    $input = '1';
    $interpreter = new Interpreter();

    $programResult = $interpreter->execute($input);

    expect($programResult->wasSuccessful())->toBeTrue();
    expect($programResult->exitCode())->toBe(0);
});
