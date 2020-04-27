<?php


namespace Worksome\CodingStyleGenerator;


use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Worksome\CodingStyleGenerator\Commands\DefaultCommand;

class Kernel
{
    public const STUB_PATH = __DIR__ . '/../stubs';
    private Application $container;

    public function __construct(Application $container)
    {
        $this->container = $container;
    }

    public function bootstrap(): void
    {
    }

    public function handle(InputInterface $input, OutputInterface $output): int
    {
        $this->bootstrap();

        $kernelApplication = new \Symfony\Component\Console\Application('PHP Insights App');

        $kernelApplication->setCommandLoader(new ContainerCommandLoader($this->container, [
            'generate' => DefaultCommand::class,
        ]));
        $kernelApplication->setDefaultCommand('generate', true);

        return $kernelApplication->run($input, $output);
    }
}