<?php

declare(strict_types=1);

namespace TennisGame\Interface\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use TennisGame\Domain\Score;

#[AsCommand(
    name: 'tennis-game:start',
    description: 'Start the tennis game'
)]
final readonly class StartCommand
{
    private const int WIDTH = 50;
    private const int HEIGHT = 9;
    private const int SIDE_WIDTH = 4;
    private const int GAP = 3;

    public function __invoke(OutputInterface $output): int
    {
        $score = Score::start();
        do {
            $this->clearScreen($output);
            $output->writeln($this->buildCourt($score));
            sleep(1);
            $score->next();
        } while ($score->isOngoing());

        return Command::SUCCESS;
    }

    private function clearScreen(OutputInterface $output): void
    {
        $output->write("\x1b[H\x1b[2J\x1b[3J");
    }

    private function buildCourt(Score $score): string
    {
        $lines = [$this->buildScoreboardLine($score->player1, $score->player2)];

        for ($row = 0; $row < self::HEIGHT; ++$row) {
            $lines[] = $this->buildRow($row);
        }

        return implode(\PHP_EOL, $lines);
    }

    private function buildRow(int $row): string
    {
        $court = $this->buildCourtSegment($row);
        [$left, $right] = $this->buildPlayerFigures($row);

        return $left . str_repeat(' ', self::GAP) . $court . str_repeat(' ', self::GAP) . $right;
    }

    private function buildCourtSegment(int $row): string
    {
        if ($this->isBorderRow($row) || $this->isSeparationRow($row)) {
            return $this->buildBorder();
        }

        return $this->buildNetRow();
    }

    private function isBorderRow(int $row): bool
    {
        return 0 === $row || self::HEIGHT - 1 === $row;
    }

    private function isSeparationRow(int $row): bool
    {
        return $row === intdiv(self::HEIGHT, 2);
    }

    private function buildBorder(): string
    {
        return '+' . str_repeat('-', self::WIDTH - 2) . '+';
    }

    private function buildNetRow(): string
    {
        $row = '|' . str_repeat(' ', self::WIDTH - 2) . '|';
        $row[intdiv(self::WIDTH, 2)] = '#';

        return $row;
    }

    /**
     * @return array{0: string, 1: string} the left and right player ASCII figures for this row, or blanks
     */
    private function buildPlayerFigures(int $row): array
    {
        $leftPlayer = [' O  ', '/|\\o', '/ \\ '];
        $rightPlayer = ['  O ', 'o/|\\', ' / \\'];
        $topRow = intdiv(self::HEIGHT - count($leftPlayer), 2);

        if ($row < $topRow || $row >= $topRow + count($leftPlayer)) {
            return [str_repeat(' ', self::SIDE_WIDTH), str_repeat(' ', self::SIDE_WIDTH)];
        }

        $index = $row - $topRow;

        return [$leftPlayer[$index], $rightPlayer[$index]];
    }

    private function buildScoreboardLine(int $leftScore, int $rightScore): string
    {
        $margin = str_repeat(' ', self::SIDE_WIDTH + self::GAP);

        return $margin . $this->centerLabel(sprintf('[ %d - %d ]', $leftScore, $rightScore));
    }

    private function centerLabel(string $label): string
    {
        $padding = self::WIDTH - \strlen($label);
        $left = (int) ceil($padding / 2);
        $right = $padding - $left;

        return str_repeat(' ', $left) . $label . str_repeat(' ', $right);
    }
}
