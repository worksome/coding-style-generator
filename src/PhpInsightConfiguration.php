<?php


namespace Worksome\CodingStyleGenerator;


use NunoMaduro\PhpInsights\Application\ConfigResolver;
use NunoMaduro\PhpInsights\Application\Console\Definitions\AnalyseDefinition;
use NunoMaduro\PhpInsights\Domain\Contracts\HasInsights;
use NunoMaduro\PhpInsights\Domain\MetricsFinder;
use Symfony\Component\Console\Input\ArrayInput;

class PhpInsightConfiguration
{
    private \NunoMaduro\PhpInsights\Domain\Configuration $phpInsightsConfiguration;

    public function __construct(string $configPath)
    {
        $phpInsightsInput = new ArrayInput(
            [
                'paths' => [getcwd()],
                '--config-path' => $configPath,
            ],
            AnalyseDefinition::get()
        );

        $configPath = ConfigResolver::resolvePath($phpInsightsInput);

        $this->phpInsightsConfiguration = ConfigResolver::resolve(
            $configPath === '' ? [] : require $configPath,
            $phpInsightsInput
        );
    }

    public function getInsights(): array
    {
        $metrics = MetricsFinder::find();
        $allInsights = [];
        foreach ($metrics as $metricClass) {
            /** @var HasInsights $metric */
            $metric = new $metricClass();

            $insights = $metric instanceof HasInsights ? $metric->getInsights() : [];

            $toAdd = $this->phpInsightsConfiguration->getAddedInsightsByMetric($metricClass);
            $insights = array_merge($insights, $toAdd);

            // Remove insights based on config.
            $allInsights = array_merge(
                $allInsights,
                array_diff($insights, $this->phpInsightsConfiguration->getRemoves())
            );
        }

        // Flip keys/values and set values to empty array
        $allInsights = array_fill_keys($allInsights, []);

        // Add configuration to insights.
        foreach ($this->phpInsightsConfiguration->getConfig() as $insight => $config) {
            if (isset($allInsights[$insight])) {
                $allInsights[$insight] = $config;
            }
        }

        return $allInsights;
    }

    public function getPreset(): string
    {
        return $this->phpInsightsConfiguration->getPreset();
    }

}