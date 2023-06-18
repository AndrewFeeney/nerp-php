<?php

namespace Nerp;

use Nerp\ProgramResultTypes\ProgramExecutedSuccessfully;

class Interpreter
{
    public function execute(string $program): ProgramResult
    {
        return new ProgramExecutedSuccessfully();
    }
}
