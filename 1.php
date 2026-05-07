<?php

class NumberFilter
{
    private array $numbers = [];

    public function addNumber(int $num): void
    {
        $this->numbers[] = $num;
    }

    public function getEven(): array
    {
        return array_filter($this->numbers, fn(int $n): bool => $n % 2 === 0);
    }

    public function getOdd(): array
    {
        return array_filter($this->numbers, fn(int $n): bool => $n % 2 !== 0);
    }

    public function getGreaterThan(int $value): array
    {
        return array_filter($this->numbers, fn(int $n): bool => $n > $value);
    }
}