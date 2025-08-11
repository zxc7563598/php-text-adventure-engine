<?php

require __DIR__ . '/../vendor/autoload.php';

use Hejunjie\TextAdventureEngine\Engine;
use Hejunjie\TextAdventureEngine\Persistence\FilePersistence;
use Hejunjie\TextAdventureEngine\PlayerState;
use Hejunjie\TextAdventureEngine\Repositories\JsonSceneRepository;

$saveDir = __DIR__ . '/../save_data';
$persistence = new FilePersistence($saveDir);
$save = $persistence->load('game-1');
if ($save) {
    $state = $save['state'];
    $sceneId = $save['currentScene'];
} else {
    $state = ['conscience' => 0];
    $sceneId = 'step-9';
}

$state = new PlayerState($state, $sceneId);
$repo = new JsonSceneRepository('/Users/lisiqi/Documents/hejunjie/text-adventure-engine/scenes.json');

$engine = new Engine($state, $repo, $persistence);

// 加载场景
print_r($engine->start($sceneId));

return false;

// 后续请求，选择场景
print_r($engine->choose('step9-1'));
