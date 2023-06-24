<?php

namespace Nerp\ProgramResultTypes;

use Nerp\ProgramResult;

class ProgramExecutedSuccessfully implements ProgramResult
{
    public function __construct(
        private ?string $standardOutput = null,
        private ?string $errorOutput = null
    )
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

    public function standardOutput(): string|null
    {
        return $this->standardOutput;
    }

    public function errorOutput(): ?string
    {
        return $this->errorOutput;
    }
}
