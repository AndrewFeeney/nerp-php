<?php

namespace Nerp\ProgramResultTypes;

use Nerp\ProgramResult;

class ProgramExecutedSuccessfully implements ProgramResult
{
    public function __construct(private ?string $standardOutput = null)
    {
    }

    public function wasSuccessful(): bool
    {
        return true;
    }

    public function exitCode(): int
    {
        return 0;
    }

    public function standardOutput(): string
    {
        return $this->standardOutput;
    }
}
