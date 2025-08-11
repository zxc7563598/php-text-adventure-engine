<?php

require __DIR__ . '/../vendor/autoload.php';

use Hejunjie\TextAdventureEngine\Engine;
use Hejunjie\TextAdventureEngine\Persistence\FilePersistence;
use Hejunjie\TextAdventureEngine\PlayerState;
use Hejunjie\TextAdventureEngine\Repositories\JsonSceneRepository;

$saveDir = __DIR__ . '/../save_data';
$persistence = new FilePersistence($saveDir);

$user_id = 'game-1'; // 模拟用户 ID

$save = $persistence->load($user_id);
if ($save) {
    $state = $save['state'];
    $sceneId = $save['currentScene'];
} else {
    $state = ['conscience' => 0];
    $sceneId = 'setp-9';
}

$state = new PlayerState($state, $sceneId);
$repo = new JsonSceneRepository(__DIR__ . '/../scenes.json');

$engine = new Engine($state, $repo, $persistence);

// 加载场景
print_r($engine->start($sceneId));

// 后续请求，选择场景
print_r($engine->choose($user_id, 'step9-1'));

print_r($engine->choose($user_id, 'step10-1'));
