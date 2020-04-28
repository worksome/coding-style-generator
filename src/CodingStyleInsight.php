<?php


namespace Worksome\CodingStyleGenerator;


use Worksome\CodingStyleGenerator\Contracts\Property;

class CodingStyleInsight
{
    private string $name;

    private array $configuration;

    public function __construct(array $configuration, string $name)
    {
        $this->name = $name;
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function getInsight(): string
    {
        return $this->configuration[Property::INSIGHT] ?? '';
    }

    public function hasInsight(): bool
    {
        return isset($this->configuration[Property::INSIGHT]);
    }

    public function isAutoChecked(): bool
    {
        return $this->hasInsight() || ($this->configuration[Property::AUTO_CHECKED] ?? false);
    }

    public function getTitle(): string
    {
        return $this->name;
    }

    public function getGoodCode(): string
    {
        return $this->configuration[Property::GOOD_CODE];
    }

    public function hasGoodCode(): bool
    {
        return isset($this->configuration[Property::GOOD_CODE]);
    }

    public function getBadCode(): string
    {
        return $this->configuration[Property::BAD_CODE];
    }

    public function hasBadCode(): bool
    {
        return isset($this->configuration[Property::BAD_CODE]);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->configuration[Property::DESCRIPTION];
    }

    public function hasDescription(): bool
    {
        return isset($this->configuration[Property::DESCRIPTION]);
    }

    public function alwaysShow(): bool
    {
        return $this->configuration[Property::ALWAYS_SHOW] ?? false;
    }
}
