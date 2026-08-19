<?php

declare(strict_types=1);

namespace App\Domain;

enum Point: int
{
    case Love = 0;
    case Fifteen = 15;
    case Thirty = 30;
    case Forty = 40;

    public function next(): self
    {
        if ($this === self::Love) {
            return Point::Fifteen;
        }
        if ($this === self::Fifteen) {
            return Point::Thirty;
        }
        if ($this === self::Thirty) {
            return Point::Forty;
        }

        throw new \LogicException('Impossible point');
    }
}
