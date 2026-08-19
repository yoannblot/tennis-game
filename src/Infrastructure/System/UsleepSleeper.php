<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Interface\Sleeper;

final readonly class UsleepSleeper implements Sleeper
{
    public function sleep(): void
    {
        usleep(1_000_000);
    }
}
