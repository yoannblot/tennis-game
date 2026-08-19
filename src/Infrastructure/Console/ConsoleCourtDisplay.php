<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Score;
use App\Interface\CourtDisplay;
use App\Interface\Sleeper;
use Symfony\Component\Console\Output\OutputInterface;

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
