<?php

declare(strict_types=1);

namespace App\Domain\State;

use App\Domain\Player;
use App\Domain\Point;

final readonly class Points extends GameState
{
    public static function start(): self
    {
        return new self(Point::Love, Point::Love);
    }

    private function __construct(
        private Point $pointPlayer1,
        private Point $pointPlayer2,
    ) {}

    public function pointWonBy(Player $player): GameState
    {
        if ($this->pointPlayer1 === Point::Forty && $this->pointPlayer2 === Point::Forty) {
            return new Advantage($player);
        }

        $pointPlayer = $player === Player::ONE ? $this->pointPlayer1 : $this->pointPlayer2;
        if ($pointPlayer === Point::Forty) {
            return new Win($player);
        }

        return $player === Player::ONE
            ? new self($this->pointPlayer1->next(), $this->pointPlayer2)
            : new self($this->pointPlayer1, $this->pointPlayer2->next());
    }

    public function __toString(): string
    {
        return $this->pointPlayer1->value . '-' . $this->pointPlayer2->value;
    }
}
