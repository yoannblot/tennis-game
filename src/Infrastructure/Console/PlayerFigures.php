<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

final readonly class PlayerFigures
{
    public const int SIDE_WIDTH = 4;

    private const array LEFT = [' O  ', '/|\\o', '/ \\ '];
    private const array RIGHT = ['  O ', 'o/|\\', ' / \\'];

    /**
     * @return array{0: string, 1: string} the left and right player ASCII figures for this row, or blanks
     */
    public function forRow(int $row): array
    {
        $topRow = intdiv(CourtGrid::HEIGHT - count(self::LEFT), num2: 2);

        if ($row < $topRow || $row >= ($topRow + count(self::LEFT))) {
            return [str_repeat(' ', self::SIDE_WIDTH), str_repeat(' ', self::SIDE_WIDTH)];
        }

        $index = $row - $topRow;

        return [self::LEFT[$index], self::RIGHT[$index]];
    }
}
