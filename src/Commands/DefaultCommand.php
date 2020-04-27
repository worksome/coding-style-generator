<?php

declare(strict_types=1);

namespace Worksome\CodingStyleGenerator\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Worksome\CodingStyleGenerator\Configuration;
use Worksome\CodingStyleGenerator\Generator;
use Worksome\CodingStyleGenerator\Kernel;
use Worksome\CodingStyleGenerator\PhpInsightConfiguration;

class DefaultCommand extends Command
{
    private Generator $generator;

    public function __construct(Generator $generator)
    {
        parent::__construct('generate');

        $this->generator = $generator;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'output-path',
            InputArgument::OPTIONAL,
            "The path to output the generated files in.",
            'docs'
        );
        $this->addOption(
            'config-path',
            null,
            InputOption::VALUE_REQUIRED
        );
        $this->addOption(
            'insight-config-path',
            null,
            InputOption::VALUE_OPTIONAL
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configPath = $input->getOption('config-path');
        $outputPath = $input->getArgument('output-path');
        $insightConfigPath = $input->getOption('insight-config-path');

        $style = new SymfonyStyle($input, $output);



        // Generate content files
        $config = new Configuration(
            require Kernel::STUB_PATH. '/config.php',
            empty($configPath) ? [] : require $configPath,
            new PhpInsightConfiguration($insightConfigPath ?? '')
        );

        $this->generator->generate(
            $style,
            $config,
            $outputPath
        );

        return 0;
    }
}
