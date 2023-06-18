<?php

namespace Nerp;

class Token
{
    public function __construct(
        public TokenType $type,
        public ?string $value = null
    )
    {
        
    }
}
