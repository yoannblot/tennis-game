<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\State\GameState;

final readonly class CourtRenderer
{
    private const int GAP = 3;

    public function __construct(
        private CourtGrid $grid,
        private PlayerFigures $playerFigures,
        private Scoreboard $scoreboard,
    ) {}

    public function render(GameState $state): string
    {
        $margin = PlayerFigures::SIDE_WIDTH + self::GAP;
        $lines = [$this->scoreboard->render((string) $state, CourtGrid::WIDTH, $margin)];

        for ($row = 0; $row < CourtGrid::HEIGHT; ++$row) {
            $lines[] = $this->buildRow($row);
        }

        return implode(\PHP_EOL, $lines);
    }

    private function buildRow(int $row): string
    {
        $court = $this->grid->segment($row);
        [$left, $right] = $this->playerFigures->forRow($row);

        return $left . str_repeat(' ', self::GAP) . $court . str_repeat(' ', self::GAP) . $right;
    }
}
