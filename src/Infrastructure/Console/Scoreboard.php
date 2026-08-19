<?php

declare(strict_types=1);

namespace TennisGame\Infrastructure\Console;

final readonly class Scoreboard
{
    public function render(int $leftScore, int $rightScore, int $width, int $margin): string
    {
        return str_repeat(' ', $margin) . $this->centerLabel(sprintf('[ %d - %d ]', $leftScore, $rightScore), $width);
    }

    private function centerLabel(string $label, int $width): string
    {
        $padding = $width - \strlen($label);
        $left = (int) ceil($padding / 2);
        $right = $padding - $left;

        return str_repeat(' ', $left) . $label . str_repeat(' ', $right);
    }
}
