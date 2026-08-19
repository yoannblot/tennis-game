<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\Player;

abstract readonly class GameState implements \Stringable
{
    abstract public function pointWonBy(Player $player): GameState;
}
