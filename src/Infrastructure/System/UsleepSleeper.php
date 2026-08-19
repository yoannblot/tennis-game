<?php

declare(strict_types=1);

namespace TennisGame\Infrastructure\System;

use TennisGame\Interface\Sleeper;

final readonly class UsleepSleeper implements Sleeper
{
    public function sleep(): void
    {
        usleep(200_000);
    }
}
