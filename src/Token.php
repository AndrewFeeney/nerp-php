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

    /**
     * If the previous token and this token can be merged, merge them and return a single
     * merged token. Otherwise return an array with the previous token and this token
     * respectively.
     *
     * @param Token $previousToken
     * @return array<Token>
     */
    public function merge(Token $previousToken): array
    {
        if ($previousToken->type->name() !== $this->type->name()) {
            return [$previousToken, $this];
        }

        $concatenatedValue = $previousToken->value . $this->value;

        if (!$this->type->matches($concatenatedValue)){
            return [$previousToken, $this];
        }

        $this->value = $concatenatedValue;

        return [$this];
    }
}
