#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use TennisGame\Interface\Console\StartCommand;

$application = new Application();
$application->addCommand(new StartCommand());
$application->run();
