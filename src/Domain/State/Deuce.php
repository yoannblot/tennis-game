<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\Player;

final readonly class Deuce extends GameState
{
    public function pointWonBy(Player $player): GameState
    {
        return new Advantage($player);
    }

    public function __toString(): string
    {
        return 'Deuce';
    }
}
