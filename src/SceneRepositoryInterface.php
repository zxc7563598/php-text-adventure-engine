<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 场景仓库接口，用于获取场景
 */
interface SceneRepositoryInterface
{
    /**
     * 根据场景 ID 获取场景
     *
     * @param string $sceneId 场景 ID
     * 
     * @return Scene|null 返回场景对象或 null（如果未找到）
     */
    public function getScene(string $sceneId): ?Scene;
}