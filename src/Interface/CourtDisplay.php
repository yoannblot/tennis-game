<?php

declare(strict_types=1);

namespace TennisGame\Interface;

use TennisGame\Domain\Score;

interface CourtDisplay
{
    public function display(Score $score): void;
}
