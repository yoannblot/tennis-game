<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Domain\Player;
use App\Interface\PointWinnerPicker;

final readonly class RandomPointWinnerPicker implements PointWinnerPicker
{
    public function pick(): Player
    {
        $cases = Player::cases();

        return $cases[random_int(0, count($cases) - 1)];
    }
}
