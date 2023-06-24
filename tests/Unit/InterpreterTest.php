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

test('it_can_interpret_a_system_print_call_with_an_integer_as_an_argument', function () {
    $input = '$system.print(1)';
    $interpreter = new Interpreter();

    $programResult = $interpreter->execute($input);

    expect($programResult->errorOutput())->toBeEmpty("Received error output: \n\n". $programResult->errorOutput());
    expect($programResult->wasSuccessful())->toBeTrue();
    expect($programResult->exitCode())->toBe(0);
    expect($programResult->standardOutput())->toBe('1');
});
