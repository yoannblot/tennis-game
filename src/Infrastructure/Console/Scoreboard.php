<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

final readonly class Scoreboard
{
    public function render(string $label, int $width, int $margin): string
    {
        return (
            str_repeat(' ', max(0, $margin))
                . $this->centerLabel(sprintf('[ %s ]', $label), $width)
        );
    }

    private function centerLabel(string $label, int $width): string
    {
        $padding = $width - \strlen($label);
        $left = (int) ceil($padding / 2);
        $right = $padding - $left;

        return str_repeat(' ', max(0, $left)) . $label . str_repeat(' ', max(0, $right));
    }
}
