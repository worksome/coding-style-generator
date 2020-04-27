<?php


namespace Worksome\CodingStyleGenerator;


use Tightenco\Collect\Support\Collection;

class Group
{
    private array $configuration;
    private string $name;

    /**
     * Group constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration, string $name)
    {
        $this->configuration = $configuration;
        $this->name = $name;
    }

    public function toFileName(): string
    {
        return strtolower(str_replace(' ', '-', $this->name));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return  $this->configuration['description'] ?? '';
    }

    public function getSubGroups()
    {
        $groups = Collection::make($this->configuration['groups'] ?? []);
        return $groups->mapInto(Group::class);
    }

    public function getInsights()
    {
        $insights = Collection::make($this->configuration['insights'] ?? []);
        return $insights->mapInto(CodingStyleInsight::class);
    }
}