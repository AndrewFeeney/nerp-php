<?php

namespace Nerp\ProgramResultTypes;

use Nerp\ProgramResult;

class ProgramEncounteredError implements ProgramResult
{
    public function __construct(private ?string $standardOutput = null, private ?int $exitCode)
    {
    }

    public function wasSuccessful(): bool
    {
        return false;
    }

    public function exitCode(): int
    {
        return $exitCode ?? 1;
    }

    public function standardOutput(): string|null
    {
        return $this->standardOutput ?? '';
    }
}

