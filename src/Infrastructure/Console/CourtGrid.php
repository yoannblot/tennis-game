<?php

declare(strict_types=1);

namespace TennisGame\Infrastructure\Console;

final readonly class CourtGrid
{
    public const int WIDTH = 50;
    public const int HEIGHT = 9;

    public function segment(int $row): string
    {
        if ($this->isBorderRow($row) || $this->isSeparationRow($row)) {
            return $this->border();
        }

        return $this->netRow();
    }

    private function isBorderRow(int $row): bool
    {
        return 0 === $row || self::HEIGHT - 1 === $row;
    }

    private function isSeparationRow(int $row): bool
    {
        return $row === intdiv(self::HEIGHT, 2);
    }

    private function border(): string
    {
        return '+' . str_repeat('-', self::WIDTH - 2) . '+';
    }

    private function netRow(): string
    {
        $row = '|' . str_repeat(' ', self::WIDTH - 2) . '|';
        $row[intdiv(self::WIDTH, 2)] = '#';

        return $row;
    }
}
