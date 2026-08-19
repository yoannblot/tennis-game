<?php

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use TennisGame\Infrastructure\Console\ConsoleCourtDisplay;
use TennisGame\Infrastructure\System\UsleepSleeper;
use TennisGame\Interface\Console\StartCommand;
use TennisGame\Interface\CourtDisplay;
use TennisGame\Interface\Sleeper;

return function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services->load('TennisGame\\', dirname(__DIR__).'/src/');

    $services->alias(CourtDisplay::class, ConsoleCourtDisplay::class);
    $services->alias(Sleeper::class, UsleepSleeper::class);
    $services->set(OutputInterface::class, ConsoleOutput::class);

    $services->set(StartCommand::class)->public();
};