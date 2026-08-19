<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\Player;

final readonly class Win extends GameState
{
    public function __construct(
        private Player $player,
    ) {}

    public function pointWonBy(Player $player): GameState
    {
        throw new \LogicException('Game is already won');
    }

    public function __toString(): string
    {
        return $this->player->value . ' win';
    }
}
