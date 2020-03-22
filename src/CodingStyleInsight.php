<?php


namespace Worksome\CodingStyleGenerator;


use Worksome\CodingStyleGenerator\Contracts\Property;

class CodingStyleInsight
{
    private string $name;

    private array $configuration;

    public function __construct($configuration, string $name)
    {
        $this->name = $name;
        $this->configuration = is_array($configuration) ? $configuration : $configuration();
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function getTitle(): string
    {
        return $this->configuration['title'] ?? $this->name;
    }

    public function getGoodCode(): string
    {
        return $this->configuration['goodCode'];
    }

    public function hasGoodCode(): bool
    {
        return isset($this->configuration['goodCode']);
    }

    public function getBadCode(): string
    {
        return $this->configuration['badCode'];
    }

    public function hasBadCode(): bool
    {
        return isset($this->configuration['badCode']);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->configuration['description'];
    }

    public function hasDescription(): bool
    {
        return isset($this->configuration['description']);
    }

    public function alwaysShow(): bool
    {
        return $this->configuration[Property::ALWAYS_SHOW] ?? false;
    }
}
