<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 选项实体类，包含跳转目标和文本
 */
class Option
{
    public string $key;
    public string $label;
    public string $desc;
    public array $conditions;
    public array $effects;

    /**
     * Option 构造函数
     *
     * @param string $key 选项的唯一标识符
     * @param string $label 选项显示文本
     * @param string $desc 选择选项后展示文本
     * @param array $conditions 条件数组，决定选项是否可用
     * @param array $effects 效果数组，应用于玩家状态
     */
    public function __construct(string $key, string $label, string $desc, array $conditions = [], array $effects = [])
    {
        $this->key = $key;
        $this->label = $label;
        $this->desc = $desc;
        $this->conditions = $conditions;
        $this->effects = $effects;
    }

    /**
     * 获取下一个场景 ID
     *
     * @param PlayerState $state 玩家状态对象
     * 
     * @return string|null 返回下一个场景 ID 或 null
     */
    public function getNextSceneId(PlayerState $state): ?string
    {
        foreach ($this->conditions as $cond) {
            if ($this->evaluateCondition($cond, $state)) {
                return $cond['nextSceneId'] ?? null;
            }
        }
        return null;
    }

    /**
     * 应用选项效果到玩家状态
     *
     * @param PlayerState $state 玩家状态对象
     */
    public function applyEffects(PlayerState $state): void
    {
        foreach ($this->effects as $effect) {
            if ($effect['type'] === 'change_attribute') {
                $state->changeAttribute($effect['key'], $effect['value']);
            } elseif ($effect['type'] === 'set_attribute') {
                $state->setAttribute($effect['key'], $effect['value']);
            }
        }
    }

    /**
     * 评估条件是否满足
     *
     * @param array $condition 条件数组
     * @param PlayerState $state 玩家状态对象
     * 
     * @return bool 返回条件是否满足
     */
    private function evaluateCondition(array $condition, PlayerState $state): bool
    {
        switch ($condition['type']) {
            case 'attribute_check':
                $logic = $condition['logic'] ?? [];
                $result = true;
                foreach ($logic as $cond) {
                    if (!$result) {
                        break;
                    }
                    $attr = $cond['attribute'];
                    $val = $cond['value'];
                    $op = $cond['operator'];
                    $curr = $state->getAttribute($attr) ?? 0;
                    $result = match ($op) {
                        '>'  => $curr > $val,
                        '>=' => $curr >= $val,
                        '<'  => $curr < $val,
                        '<=' => $curr <= $val,
                        '==' => $curr == $val,
                        '!=' => $curr != $val,
                        default => false,
                    };
                }
                return $result;
            case 'always_true':
                return true;
            default:
                return false;
        }
    }
}
