<?php

namespace Hejunjie\TextAdventureEngine;

// 选项实体类，包含跳转目标和文本
class Option
{
    protected string $key;
    protected string $label;
    protected string $nextSceneId;
    protected array $effects = []; // 例如 [['type' => 'change_attribute', 'key' => 'hp', 'value' => -1]]

    public function __construct(string $key, string $label, string $nextSceneId, array $effects = [])
    {
        $this->key = $key;
        $this->label = $label;
        $this->nextSceneId = $nextSceneId;
        $this->effects = $effects;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getNextSceneId(): string
    {
        return $this->nextSceneId;
    }

    public function getEffects(): array
    {
        return $this->effects;
    }
}
