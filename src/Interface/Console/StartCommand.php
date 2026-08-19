<?php

declare(strict_types=1);

namespace TennisGame\Interface\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use TennisGame\Domain\Score;
use TennisGame\Interface\CourtDisplay;

#[AsCommand(
    name: 'tennis-game:start',
    description: 'Start the tennis game'
)]
final readonly class StartCommand
{
    public function __construct(private CourtDisplay $courtDisplay) {}

    public function __invoke(): int
    {
        $score = Score::start();
        do {
            $this->courtDisplay->display($score);
            $score->next();
        } while ($score->isOngoing());

        return Command::SUCCESS;
    }
}
