<?php

namespace Hejunjie\TextAdventureEngine;

/**
 * 核心引擎类，负责管理游戏流程和玩家状态
 */
class Engine
{
    private PlayerState $playerState;
    private SceneRepositoryInterface $sceneRepo;
    protected PersistenceInterface $persistence;

    /**
     * Engine 构造函数
     *
     * @param PlayerState $playerState 玩家状态对象
     * @param SceneRepositoryInterface $sceneRepo 场景仓库接口实现
     */
    public function __construct(PlayerState $playerState, SceneRepositoryInterface $sceneRepo,PersistenceInterface $persistence)
    {
        $this->playerState = $playerState;
        $this->sceneRepo = $sceneRepo;
        $this->persistence = $persistence;
    }

    /**
     * 开始游戏，设置初始场景
     *
     * @param string $sceneId 初始场景 ID
     * 
     * @return array 返回当前场景数据
     */
    public function start(string $sceneId): array
    {
        $this->playerState->setCurrentSceneId($sceneId);
        return $this->getCurrentSceneData();
    }

    /**
     * 处理用户选择的选项
     *
     * @param string $optionKey 用户选择的 Key
     * 
     * @return array|null 返回下一个场景数据或 null（游戏结束）
     * @throws \RuntimeException 如果找不到当前场景
     * @throws \InvalidArgumentException 如果选项无效
     */
    public function choose(string $optionKey): ?array
    {
        $scene = $this->sceneRepo->getScene($this->playerState->getCurrentSceneId());
        if (!$scene) {
            throw new \RuntimeException("找不到场景：{$this->playerState->getCurrentSceneId()}");
        }
        $chosenOption = $scene->findOption($optionKey);
        if (!$chosenOption) {
            throw new \InvalidArgumentException("无效选项：{$optionKey}");
        }
        // 先应用效果
        $chosenOption->applyEffects($this->playerState);
        // 获取下一场景 ID
        $nextSceneId = $chosenOption->getNextSceneId($this->playerState);
        // 存储进度
        $this->persistence->save('game-1', $this->playerState, $nextSceneId);
        if (!$nextSceneId) {
            return null; // 游戏结束
        }
        $this->playerState->setCurrentSceneId($nextSceneId);
        return $this->getCurrentSceneData();
    }

    /**
     * 获取当前场景的数据
     *
     * @return array 返回当前场景的描述、选项和玩家状态
     * @throws \RuntimeException 如果找不到当前场景
     */
    private function getCurrentSceneData(): array
    {
        $scene = $this->sceneRepo->getScene($this->playerState->getCurrentSceneId());
        if (!$scene) {
            throw new \RuntimeException("找不到场景：{$this->playerState->getCurrentSceneId()}");
        }
        return [
            'sceneId'    => $scene->getId(),
            'description' => $scene->getDescription(),
            'options'    => array_map(fn($opt) => [
                'key'   => $opt->key,
                'label' => $opt->label
            ], $scene->getOptions()),
            'player'     => $this->playerState->getAllAttributes()
        ];
    }
}
