<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TennisGame\Domain\Score;

final class ScoreTest extends TestCase
{
    public function testItStartsAScoreZeroToZero(): void
    {
        $actual = Score::start();

        self::assertSame(0, $actual->player1);
        self::assertSame(0, $actual->player2);
    }
}
