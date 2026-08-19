<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Score;
use PHPUnit\Framework\TestCase;

final class ScoreTest extends TestCase
{
    public function testItStartsAScoreZeroToZero(): void
    {
        $actual = Score::start();

        self::assertSame(0, $actual->player1);
        self::assertSame(0, $actual->player2);
    }
}
