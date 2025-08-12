<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 玩家状态类，管理玩家的属性和当前场景
 */
class PlayerState
{
    private array $attributes = [];
    private string $currentSceneId;

    /**
     * PlayerState 构造函数
     *
     * @param array $initialAttributes 初始属性
     * @param string $startSceneId 开始场景 ID
     */
    public function __construct(array $initialAttributes = [], string $startSceneId = '')
    {
        $this->attributes = $initialAttributes;
        $this->currentSceneId = $startSceneId;
    }

    /**
     * 获取指定属性的值
     *
     * @param string $key 属性键
     * 
     * @return mixed 返回属性值或 null
     */
    public function getAttribute(string $key)
    {
        return $this->attributes[$key]['value'] ?? null;
    }

    /**
     * 设置指定属性的值
     *
     * @param string $key 属性键
     * @param mixed $value 属性值
     */
    public function setAttribute(string $key, $value): void
    {
        $this->attributes[$key]['value'] = $value;
    }

    /**
     * 修改指定属性的值
     *
     * @param string $key 属性键
     * @param mixed $delta 增量值
     */
    public function changeAttribute(string $key, $delta): void
    {
        $this->attributes[$key]['value'] = ($this->attributes[$key]['value'] ?? 0) + $delta;
    }

    /**
     * 获取所有属性
     *
     * @return array 返回所有属性数组
     */
    public function getAllAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * 获取当前场景 ID
     *
     * @return string 返回当前场景 ID
     */
    public function getCurrentSceneId(): string
    {
        return $this->currentSceneId;
    }

    /**
     * 设置当前场景 ID
     *
     * @param string $sceneId 场景 ID
     */
    public function setCurrentSceneId(string $sceneId): void
    {
        $this->currentSceneId = $sceneId;
    }
}
