<?php

declare(strict_types=1);

namespace App\Interface\Console;

use App\Domain\Score;
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
        $score = Score::start();
        do {
            $this->courtDisplay->display($score);
            $score->next();
        } while ($score->isOngoing());

        return Command::SUCCESS;
    }
}
