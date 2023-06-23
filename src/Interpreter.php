<?php

namespace Nerp;

use Nerp\ProgramResultTypes\ProgramExecutedSuccessfully;

class Interpreter
{
    public function execute(string $program): ProgramResult
    {
        $tokenList = (new Lexer())->lex($program);

        $abstractSyntaxTree = (new Parser())->parse($tokenList);

        $system = new System();

        try {
            $result = (new Evaluator($system))->evaluate($abstractSyntaxTree);
        } catch (\Exception $e) {
            return new ProgramEncounteredError($e);
        }

        return new ProgramExecutedSuccessfully($system->standardOutput());
    }
}
