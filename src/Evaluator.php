<?php

namespace Nerp;

class Evaluator
{
    public function __construct(private System $system)
    {        
    }

    public function evaluate(SyntaxNode $ast)
    {
        return $ast->evaluate($this->system);
    } 
}
