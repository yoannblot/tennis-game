<?php

declare(strict_types=1);

namespace TennisGame\Interface;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'tennis-game:start',
    description: 'Start the tennis game'
)]
final readonly class StartCommand
{
    public function __invoke(OutputInterface $output): int
    {
        $output->writeln('<info>Starting game</info>');

        return Command::SUCCESS;
    }
}
