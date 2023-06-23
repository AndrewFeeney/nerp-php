<?php

use Nerp\Interpreter;

test('it_can_interpret_an_integer', function () {
    $input = '1';
    $interpreter = new Interpreter();

    $programResult = $interpreter->execute($input);

    expect($programResult->wasSuccessful())->toBeTrue();
    expect($programResult->exitCode())->toBe(0);
    expect($programResult->standardOutput())->toBe('');
});

test('it_can_interpret_a_print_call_on_an_integer', function () {
    $input = '1.print()';
    $interpreter = new Interpreter();

    $programResult = $interpreter->execute($input);

    expect($programResult->wasSuccessful())->toBeTrue();
    expect($programResult->exitCode())->toBe(0);
    expect($programResult->standardOutput())->toBe('1');
});
