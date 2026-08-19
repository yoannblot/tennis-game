<?php

declare(strict_types=1);

namespace App\Interface\Console;

use App\Domain\Game;
use App\Domain\Player;
use App\Domain\State\Win;
use App\Interface\CourtDisplay;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'tennis-game:start', description: 'Start the tennis game')]
final readonly class StartCommand
{
    public function __construct(
        private CourtDisplay $courtDisplay,
    ) {}

    public function __invoke(): int
    {
        $points = [
            Player::ONE,
            Player::TWO,
            Player::ONE,
            Player::ONE,
            Player::TWO,
            Player::TWO,
            Player::ONE,
            Player::TWO,
            Player::ONE,
            Player::ONE,
        ];
        $game = new Game();

        for ($played = 1; $played <= count($points); ++$played) {
            $state = $game->play(array_slice($points, offset: 0, length: $played));
            $this->courtDisplay->display($state);

            if ($state instanceof Win) {
                break;
            }
        }

        return Command::SUCCESS;
    }
}
