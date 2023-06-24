<?php

namespace Nerp;

interface ProgramResult
{
    public function wasSuccessful(): bool;

    public function exitCode(): int;

    public function standardOutput(): string|null;

    public function errorOutput(): string|null;
}
