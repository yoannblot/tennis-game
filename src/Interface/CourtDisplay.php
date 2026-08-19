<?php

declare(strict_types=1);

namespace App\Interface;

use App\Domain\State\GameState;

interface CourtDisplay
{
    public function display(GameState $state): void;
}
