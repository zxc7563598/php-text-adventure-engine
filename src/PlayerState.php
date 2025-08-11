<?php

namespace Hejunjie\TextAdventureEngine;

// 玩家状态类，管理属性和状态（生命值、金币等）
class PlayerState {
    protected array $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    // 读取属性值
    public function getAttribute(string $key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    // 设置属性值
    public function setAttribute(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    // 返回所有属性数组
    public function toArray(): array
    {
        return $this->attributes;
    }
}