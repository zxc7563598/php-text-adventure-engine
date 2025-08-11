<?php

namespace Hejunjie\TextAdventureEngine;

// 核心引擎类，负责管理游戏流程和玩家状态
class Engine
{
    protected array $scenes = [];
    protected PersistenceInterface $persistence;
    protected array $playerStates = []; // 运行时缓存玩家状态
    protected array $currentScenes = []; // 运行时缓存玩家当前场景

    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }

    // 添加场景
    public function addScene(Scene $scene): void
    {
        $this->scenes[$scene->getId()] = $scene;
    }

    // 启动或恢复游戏
    public function startGame(string $playerId, string $startSceneId): array
    {
        $data = $this->persistence->load($playerId);
        if ($data) {
            // 读档
            $this->playerStates[$playerId] = $data['state'];
            $this->currentScenes[$playerId] = $data['currentScene'];
        } else {
            // 新玩家，默认属性
            $state = new PlayerState();
            $state->setAttribute('conscience', 0);
            $this->playerStates[$playerId] = $state;
            $this->currentScenes[$playerId] = $startSceneId;
        }
        return $this->getCurrentSceneData($playerId);
    }

    // 玩家做出选择，流程推进
    public function makeChoice(string $playerId, string $optionKey): array
    {
        $currentSceneId = $this->currentScenes[$playerId] ?? null;
        if (!$currentSceneId) {
            return ['error' => '游戏未启动'];
        }
        $scene = $this->scenes[$currentSceneId] ?? null;
        if (!$scene) {
            return ['error' => '当前场景不存在'];
        }

        $option = $scene->getOption($optionKey);
        if (!$option) {
            return ['error' => '无效选项'];
        }

        foreach ($option->getEffects() as $effect) {
            if ($effect['type'] === 'change_attribute') {
                $key = $effect['key'];
                $delta = $effect['value'];
                $current = $this->playerStates[$playerId]->getAttribute($key, 0);
                $this->playerStates[$playerId]->setAttribute($key, $current + $delta);
            }
            // 以后可以扩展其他效果类型
        }

        $nextSceneId = $option->getNextSceneId($this->playerStates[$playerId]);
        $this->currentScenes[$playerId] = $nextSceneId;

        $this->persistence->save($playerId, $this->playerStates[$playerId], $nextSceneId);

        return $this->getCurrentSceneData($playerId);
    }

    // 获取玩家当前场景描述和选项
    public function getCurrentSceneData(string $playerId): array
    {
        $currentSceneId = $this->currentScenes[$playerId] ?? null;
        if (!$currentSceneId) {
            return ['error' => '游戏未启动'];
        }
        $scene = $this->scenes[$currentSceneId] ?? null;
        if (!$scene) {
            return ['error' => '当前场景不存在'];
        }

        // 返回场景描述和选项列表
        $options = [];
        foreach ($scene->getOptions() as $key => $option) {
            $options[] = ['key' => $key, 'label' => $option->getLabel()];
        }

        return [
            'sceneId' => $currentSceneId,
            'description' => $scene->getDescription(),
            'options' => $options,
            'playerState' => $this->playerStates[$playerId]->toArray(),
        ];
    }

    // 获取玩家状态
    public function getPlayerState(string $playerId): PlayerState
    {
        return $this->playerStates[$playerId] ?? new PlayerState();
    }

    // 设置玩家状态
    public function setPlayerState(string $playerId, PlayerState $state): void
    {
        $this->playerStates[$playerId] = $state;
    }
}