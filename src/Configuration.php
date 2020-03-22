<?php


namespace Worksome\CodingStyleGenerator;


use Tightenco\Collect\Support\Collection;

class Configuration
{
    private array $configuration;

    public function __construct(array $defaultConfiguration, array $userConfiguration, array $allInsights)
    {
        $this->configuration = self::mergeConfig($defaultConfiguration, $userConfiguration);
        array_walk_recursive(
            $this->configuration,
            function (&$item, string $key) use ($allInsights) {
                if (!is_array($item) && isset($allInsights[$key])) {
                    $item = $item($allInsights[$key]);
                }
            }
        );
    }

    /**
     * @return Group[]|Collection
     */
    public function getGroups(): Collection
    {
        $groups = Collection::make($this->configuration['groups'] ?? []);
        return $groups->mapInto(Group::class);
    }

    public function getTitle(): string
    {
        return $this->configuration['title'];
    }

    public function getDescription(): string
    {
        return $this->configuration['description'];
    }

    private static function mergeConfig(array $defaultConfiguration, array $userConfiguration): array
    {
        return array_merge_recursive($defaultConfiguration, $userConfiguration);
    }
}
