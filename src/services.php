<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Worksome\CodingStyleGenerator\Application;
use Worksome\CodingStyleGenerator\Commands\DefaultCommand;
use Worksome\CodingStyleGenerator\Generator;
use Worksome\CodingStyleGenerator\Kernel;

return static function (ContainerConfigurator $configurator): void {
    $services = $configurator->services();
    $services->defaults()->autowire()->public();

    $services->set(Kernel::class);
    $services->set(Application::class)->synthetic();
    $services->set(DefaultCommand::class);
    $services->set(Generator::class);
};
