<?php

declare(strict_types=1);

namespace TennisGame\Infrastructure\Console;

use Symfony\Component\Console\Output\OutputInterface;
use TennisGame\Domain\Score;
use TennisGame\Interface\CourtDisplay;
use TennisGame\Interface\Sleeper;

final readonly class ConsoleCourtDisplay implements CourtDisplay
{
    public function __construct(
        private OutputInterface $output,
        private Sleeper $sleeper,
        private CourtRenderer $renderer,
        private ScreenClearer $screenClearer,
    ) {}

    public function display(Score $score): void
    {
        $this->screenClearer->clear();
        $this->output->writeln($this->renderer->render($score));
        $this->sleeper->sleep();
    }
}
