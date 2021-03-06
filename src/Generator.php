<?php


namespace Worksome\CodingStyleGenerator;


use Exception;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Generator
{
    private Environment $twig;

    private static $stubFiles = [
        '.gitignore',
        'package.json',
        'README.md',
        '.vuepress/',
        '.vuepress/config.js',
        '.vuepress/components/',
        '.vuepress/components/AutoChecked.vue',
    ];

    public function __construct(string $stubPath = Kernel::STUB_PATH)
    {
        $loader = new FilesystemLoader($stubPath);
        $twig = new Environment($loader);

        $this->twig = $twig;
    }

    public function generate(SymfonyStyle $output,
                             Configuration $config,
                             string $outputPath): void
    {
        // Create output folder
        if (!file_exists($outputPath)) {
            mkdir($outputPath, 0777);
        }

        $this->generateStubFiles($output, $outputPath, $config);

        $this->generateStyleFiles($config, $outputPath, $output);
    }

    private function generateStubFiles(SymfonyStyle $output, string $outputPath, Configuration $config): void
    {
        $output->section("Generate stub files");
        $created = [];

        foreach (self::$stubFiles as $fileName) {
            $dest = "$outputPath/{$fileName}";

            if (file_exists($dest)) {
                continue;
            }

            // Check if it's a directory.
            if (substr($dest, -1) === '/') {
                mkdir($dest, 0777);
                continue;
            }

            $file = fopen($dest, 'w');

            fwrite(
                $file,
                $this->twig->render("vuepress/{$fileName}.twig", ['config' => $config])
            );

            fclose($file);
            chmod($dest, 0777);

            $created[] = $dest;
        }

        if ($created === []) {
            $output->writeln("None generated, they all already exist.");
        }

        $output->listing($created);
    }

    public function generateStyleFiles(Configuration $config, string $outputPath, SymfonyStyle $output): void
    {
        $output->section("Generate style files");

        $template = $this->twig->load('group.md.twig');
        $files = $config->getGroups()->map(function (Group $group) use ($outputPath, $output, $template) {
            $folder = "{$outputPath}/generated";
            if (!file_exists($folder)) {
                mkdir($folder, 0777);
            }

            $file = fopen("{$folder}/{$group->toFileName()}.md", 'w');

            if ($file === false) {
                throw new Exception("Couldn't create file.");
            }
            fwrite(
                $file,
                $template->render(['group' => $group, 'level' => 1])
            );

            fclose($file);
            chmod("{$folder}/{$group->toFileName()}.md", 0777);

            return "{$folder}/{$group->toFileName()}.md";
        });

        $output->listing($files->all());
    }
}