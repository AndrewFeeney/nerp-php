<?php

namespace Nerp\ProgramResultTypes;

use Nerp\ProgramResult;

class ProgramEncounteredError implements ProgramResult
{
    public function __construct(
        private ?string $standardOutput = null,
        private ?string $errorOutput = null,
        private ?int $exitCode
    )
    {
    }

    public function wasSuccessful(): bool
    {
        return false;
    }

    public function exitCode(): int
    {
        return $this->exitCode ?? 1;
    }

    public function standardOutput(): string|null
    {
        return $this->standardOutput ?? '';
    }

    public function errorOutput(): ?string
    {
        return $this->standardOutput;
    }
}

