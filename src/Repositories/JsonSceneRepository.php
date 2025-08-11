<?php

namespace Hejunjie\TextAdventureEngine\Repositories;

use Hejunjie\TextAdventureEngine\Scene;
use Hejunjie\TextAdventureEngine\Option;
use Hejunjie\TextAdventureEngine\SceneRepositoryInterface;

/**
 * JsonSceneRepository 实现了 SceneRepositoryInterface，负责从 JSON 文件加载场景数据
 */
class JsonSceneRepository implements SceneRepositoryInterface
{
    private array $data;

    /**
     * JsonSceneRepository 构造函数
     *
     * @param string $jsonFile JSON 文件路径
     * 
     * @throws \InvalidArgumentException 如果文件不存在或无法读取
     * @throws \RuntimeException 如果 JSON 解码失败
     */
    public function __construct(string $jsonFile)
    {
        if (!file_exists($jsonFile)) {
            throw new \InvalidArgumentException("JSON file not found: $jsonFile");
        }
        $jsonContent = file_get_contents($jsonFile);
        $decoded = json_decode($jsonContent, true);
        if ($decoded === null) {
            throw new \RuntimeException("Failed to decode JSON from file: $jsonFile");
        }
        $this->data = $decoded;
    }

    /**
     * 根据场景 ID 获取场景
     *
     * @param string $sceneId 场景 ID
     * @return Scene|null 返回场景对象或 null
     */
    public function getScene(string $sceneId): ?Scene
    {
        if (!isset($this->data[$sceneId])) {
            return null;
        }
        $sceneData = $this->data[$sceneId];
        $scene = new Scene($sceneData['id'], $sceneData['description']);
        foreach ($sceneData['options'] as $opt) {
            $scene->addOption(new Option(
                $opt['key'],
                $opt['label'],
                $opt['desc'],
                $opt['conditions'] ?? [],
                $opt['effects'] ?? []
            ));
        }
        return $scene;
    }
}
