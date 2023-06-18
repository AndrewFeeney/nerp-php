<?php

namespace Nerp;

class Evaluator
{
    public function evaluate(SyntaxNode $ast)
    {
        return $ast->evaluate();
    } 
}
