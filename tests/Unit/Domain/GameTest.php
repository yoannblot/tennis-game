<?php

declare(strict_types=1);

namespace Tests\Unit\Domain;

use App\Domain\Game;
use App\Domain\Player;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    private Game $sut;

    protected function setUp(): void
    {
        $this->sut = new Game();
    }

    #[TestWith([0, 0, '0-0'])]
    #[TestWith([1, 0, '15-0'])]
    #[TestWith([0, 1, '0-15'])]
    #[TestWith([2, 0, '30-0'])]
    #[TestWith([3, 0, '40-0'])]
    #[TestWith([3, 1, '40-15'])]
    #[TestWith([2, 3, '30-40'])]
    public function testItDisplaysValidScore(int $pointsPlayer1, int $pointsPlayer2, string $result): void
    {
        $scores = $this->calculateScores($pointsPlayer1, $pointsPlayer2);

        $actual = $this->sut->play($scores);

        self::assertSame($result, (string) $actual);
    }

    public function testItDisplaysPlayer1WhenItScores4InARaw(): void
    {
        $scores = $this->calculateScores(4, 0);

        $actual = $this->sut->play($scores);

        self::assertSame('Player 1 win', (string) $actual);
    }

    public function testItDisplaysPlayer2WhenItScores4InARaw(): void
    {
        $scores = $this->calculateScores(0, 4);

        $actual = $this->sut->play($scores);

        self::assertSame('Player 2 win', (string) $actual);
    }

    #[TestWith([4, 4])]
    #[TestWith([5, 5])]
    #[TestWith([6, 6])]
    #[TestWith([12, 12])]
    public function testItDisplaysDeuceWhenBothHave4Points(int $pointsPlayer1, int $pointsPlayer2): void
    {
        $scores = $this->calculateScores($pointsPlayer1, $pointsPlayer2);

        $actual = $this->sut->play($scores);

        self::assertSame('Deuce', (string) $actual);
    }

    #[TestWith([5, 4, 'Advantage Player 1'])]
    #[TestWith([6, 5, 'Advantage Player 1'])]
    #[TestWith([4, 5, 'Advantage Player 2'])]
    #[TestWith([7, 8, 'Advantage Player 2'])]
    public function testItDisplaysAdvantageToRightPlayer(int $pointsPlayer1, int $pointsPlayer2, string $result): void
    {
        $scores = $this->calculateScores($pointsPlayer1, $pointsPlayer2);

        $actual = $this->sut->play($scores);

        self::assertSame($result, (string) $actual);
    }

    /**
     * @return list<Player>
     */
    private function calculateScores(int $pointsPlayer1, int $pointsPlayer2): array
    {
        if ($pointsPlayer1 > 3 && $pointsPlayer2 > 3) {
            return $this->calculateScoresAboveDeuce($pointsPlayer1, $pointsPlayer2);
        }

        return array_merge(
            array_pad([], $pointsPlayer1, Player::ONE),
            array_pad([], $pointsPlayer2, Player::TWO),
        );
    }

    /**
     * @return list<Player>
     */
    private function calculateScoresAboveDeuce(int $pointsPlayer1, int $pointsPlayer2): array
    {
        $scores = $this->calculateScores(3, 3);
        $pointsPlayer1 -= 3;
        $pointsPlayer2 -= 3;
        do {
            if ($pointsPlayer1 > 0) {
                $scores[] = Player::ONE;
                $pointsPlayer1--;
            }
            if ($pointsPlayer2 > 0) {
                $scores[] = Player::TWO;
                $pointsPlayer2--;
            }
        } while ($pointsPlayer1 > 0 || $pointsPlayer2 > 0);

        return $scores;
    }
}
