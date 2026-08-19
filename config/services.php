<?php

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use App\Infrastructure\Console\ConsoleCourtDisplay;
use App\Infrastructure\System\UsleepSleeper;
use App\Interface\Console\StartCommand;
use App\Interface\CourtDisplay;
use App\Interface\Sleeper;

return function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services->load('App\\', dirname(__DIR__).'/src/');

    $services->alias(CourtDisplay::class, ConsoleCourtDisplay::class);
    $services->alias(Sleeper::class, UsleepSleeper::class);
    $services->set(OutputInterface::class, ConsoleOutput::class);

    $services->set(StartCommand::class)->public();
};
