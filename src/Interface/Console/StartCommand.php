<?php

declare(strict_types=1);

namespace App\Interface\Console;

use App\Domain\Game;
use App\Domain\State\Win;
use App\Interface\CourtDisplay;
use App\Interface\PointWinnerPicker;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'tennis-game:start', description: 'Start the tennis game')]
final readonly class StartCommand
{
    public function __construct(
        private CourtDisplay $courtDisplay,
        private PointWinnerPicker $pointWinnerPicker,
    ) {}

    public function __invoke(): int
    {
        $game = new Game();
        $points = [];

        do {
            $points[] = $this->pointWinnerPicker->pick();
            $state = $game->play($points);
            $this->courtDisplay->display($state);
        } while (!$state instanceof Win);

        return Command::SUCCESS;
    }
}
