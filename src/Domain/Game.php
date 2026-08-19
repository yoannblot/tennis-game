<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\State\GameState;
use App\Domain\State\Points;
use App\Domain\State\Win;

final readonly class Game
{
    /**
     * @param list<Player> $points
     */
    public function play(array $points): GameState
    {
        $state = Points::start();
        foreach ($points as $point) {
            $state = $state->pointWonBy($point);

            if ($state instanceof Win) {
                return $state;
            }
        }

        return $state;
    }
}
