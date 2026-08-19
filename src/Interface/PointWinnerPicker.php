<?php

declare(strict_types=1);

namespace App\Interface;

use App\Domain\Player;

interface PointWinnerPicker
{
    public function pick(): Player;
}
