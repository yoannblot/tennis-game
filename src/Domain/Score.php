<?php

declare(strict_types=1);

namespace TennisGame\Domain;

final class Score
{
    public static function start(): self
    {
        return new self(0, 0);
    }

    private function __construct(public int $player1, public int $player2) {}

    public function next(): void
    {
        $this->player1++;
    }

    public function isOngoing(): bool
    {
        return $this->player1 <= 10;
    }

}
