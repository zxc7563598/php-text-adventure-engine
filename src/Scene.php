<?php

namespace Hejunjie\TextAdventureEngine;

// 场景实体类，包含描述和选项
class Scene
{
    protected string $id;
    protected string $description;
    /** @var Option[] */
    protected array $options = [];

    public function __construct(string $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function addOption(Option $option): void
    {
        $this->options[$option->getKey()] = $option;
    }

    public function getOption(string $key): ?Option
    {
        return $this->options[$key] ?? null;
    }

    /**
     * @return Option[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
