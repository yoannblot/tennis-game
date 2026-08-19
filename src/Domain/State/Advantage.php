<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\Player;

final readonly class Advantage extends GameState
{
    public function __construct(
        private Player $player,
    ) {}

    public function pointWonBy(Player $player): GameState
    {
        if ($this->player === $player) {
            return new Win($player);
        }

        return new Deuce();
    }

    public function __toString(): string
    {
        return 'Advantage ' . $this->player->value;
    }
}
