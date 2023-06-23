<?php

namespace Nerp;

class System
{
    public function __construct(private array $outputLines = [])
    {

    }

    public function print(mixed $output)
    {
        $this->outputLines[] = (string) $output;
    }

    public function standardOutput(): string
    {
        return implode("\n", $this->outputLines);
    }
}