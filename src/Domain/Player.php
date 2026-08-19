<?php

declare(strict_types=1);

namespace App\Domain;

enum Player: string
{
    case ONE = 'Player 1';
    case TWO = 'Player 2';
}
