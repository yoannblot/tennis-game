<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use Symfony\Component\Console\Output\OutputInterface;

final readonly class ScreenClearer
{
    public function __construct(
        private OutputInterface $output,
    ) {}

    public function clear(): void
    {
        $this->output->write("\x1b[H\x1b[2J\x1b[3J");
    }
}
