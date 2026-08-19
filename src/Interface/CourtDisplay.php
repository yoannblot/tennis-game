<?php

declare(strict_types=1);

namespace App\Interface;

use App\Domain\Score;

interface CourtDisplay
{
    public function display(Score $score): void;
}
