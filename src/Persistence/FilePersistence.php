<?php

namespace Hejunjie\TextAdventureEngine\Persistence;

use Hejunjie\TextAdventureEngine\PersistenceInterface;
use Hejunjie\TextAdventureEngine\PlayerState;

// 文件保存/加载存档的示例实现
class FilePersistence implements PersistenceInterface
{
    protected string $saveDir;

    public function __construct(string $saveDir)
    {
        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }
        $this->saveDir = rtrim($saveDir, '/');
    }

    public function save(string $playerId, PlayerState $state, string $currentScene): void
    {
        $data = [
            'attributes' => $state->getAllAttributes(),
            'currentScene' => $currentScene,
        ];
        file_put_contents($this->getFilePath($playerId), json_encode($data));
    }

    public function load(string $playerId): ?array
    {
        $file = $this->getFilePath($playerId);
        if (!file_exists($file)) {
            return null;
        }
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        if (!$data) {
            return null;
        }
        return ['state' => $data['attributes'] ?? [], 'currentScene' => $data['currentScene'] ?? null];
    }

    protected function getFilePath(string $playerId): string
    {
        return $this->saveDir . '/' . md5($playerId) . '.json';
    }
}
