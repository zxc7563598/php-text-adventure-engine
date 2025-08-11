<?php

namespace Hejunjie\TextAdventureEngine;

// 存档接口，定义保存和读取玩家进度的方法
interface PersistenceInterface
{
    public function save(string $playerId, PlayerState $state, string $currentScene): void;

    /**
     * @return array|null ['state' => PlayerState, 'currentScene' => string] 或 null
     */
    public function load(string $playerId): ?array;
}