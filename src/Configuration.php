<?php


namespace Worksome\CodingStyleGenerator;


use Closure;
use Tightenco\Collect\Support\Collection;

class Configuration
{
    private array $configuration;
    private array $enabledInsights;

    public function __construct(array $defaultConfiguration,
                                array $userConfiguration,
                                PhpInsightConfiguration $phpInsightConfiguration)
    {
        $this->configuration = self::mergeConfig($defaultConfiguration, $userConfiguration);
        $this->enabledInsights = $phpInsightConfiguration->getInsights();

        foreach ($this->configuration['groups'] as $groupName => ['groups' => $subGroups]) {
            foreach ($subGroups as $subGroupName => ['insights' => $insights]) {
                foreach ($insights as $insightTitle => $data) {
                    if ($data instanceof Closure) {
                        $data = $data($this->enabledInsights);
                        $this->configuration['groups'][$groupName]['groups'][$subGroupName]['insights'][$insightTitle] = $data;
                    }

                    if (isset($data['insight']) && !key_exists($data['insight'], $this->enabledInsights)) {
                        unset($this->configuration['groups'][$groupName]['groups'][$subGroupName]['insights'][$insightTitle]);
                    }
                }
            }
        }
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

    public function getEnabledInsights(): array
    {
        return $this->enabledInsights;
    }
}
