<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 场景实体类，包含场景描述和选项
 */
class Scene
{
    private string $id;
    private string $description;
    /** @var Option[] */
    private array $options = [];

    /**
     * Scene 构造函数
     *
     * @param string $id 场景的唯一标识符
     * @param string $description 场景描述文本
     */
    public function __construct(string $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    /**
     * 添加选项到场景
     *
     * @param Option $option 选项对象
     */
    public function addOption(Option $option): void
    {
        $this->options[] = $option;
    }

    /**
     * 获取场景 ID
     *
     * @return string 场景 ID
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * 获取场景描述
     *
     * @return string 场景描述文本
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * 获取所有选项
     *
     * @return Option[] 返回选项数组
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * 根据选项 Key 查找选项
     *
     * @param string $key 选项的唯一标识符
     * @return Option|null 返回找到的选项或 null
     */
    public function findOption(string $key): ?Option
    {
        foreach ($this->options as $opt) {
            if ($opt->key === $key) {
                return $opt;
            }
        }
        return null;
    }
}
