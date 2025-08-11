<?php

namespace Hejunjie\TextAdventureEngine;

// 选项实体类，包含跳转目标和文本
class Option
{
    protected string $key;
    protected string $label;
    /**
     * 条件跳转数组，结构示例：
     * [
     *   ['condition' => fn(PlayerState $state) => $state->getAttribute('hp') > 3, 'nextSceneId' => 'scene_good'],
     *   ['condition' => fn(PlayerState $state) => true, 'nextSceneId' => 'scene_bad'],
     * ]
     */
    protected array $conditionalNextScenes = [];
    protected array $effects = []; // 例如 [['type' => 'change_attribute', 'key' => 'hp', 'value' => -1]]

    public function __construct(string $key, string $label, array $conditionalNextScenes = [], array $effects = [])
    {
        $this->key = $key;
        $this->label = $label;
        $this->conditionalNextScenes = $conditionalNextScenes;
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

    public function getNextSceneId(PlayerState $state): ?string
    {
        foreach ($this->conditionalNextScenes as $cond) {
            if (($cond['condition'])($state)) {
                return $cond['nextSceneId'];
            }
        }
        return null;
    }

    public function getEffects(): array
    {
        return $this->effects;
    }
}
