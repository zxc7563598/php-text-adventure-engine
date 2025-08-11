<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 持久化接口，用于保存和加载玩家状态
 */
interface PersistenceInterface
{
    /**
     * 保存玩家状态
     *
     * @param string $playerId 玩家 ID
     * @param PlayerState $state 玩家状态对象
     * @param string $currentScene 当前场景 ID
     */
    public function save(string $playerId, PlayerState $state, string $currentScene): void;

    /**
     * 加载玩家状态
     *
     * @param string $playerId 玩家 ID
     * 
     * @return PlayerState|null 返回玩家状态对象或 null（如果未找到）
     */
    public function load(string $playerId): ?array;
}