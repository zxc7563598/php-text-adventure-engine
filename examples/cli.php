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
    $state = ['health' => ['key' => '健康', 'value' => 100], 'courage' => ['key' => '勇气', 'value' => 50], 'wisdom' => ['key' => '智慧', 'value' => 30]]; // 初始状态
    $sceneId = 'start';
}

$state = new PlayerState($state, $sceneId);
$repo = new JsonSceneRepository(__DIR__ . '/../scenes.json');

$engine = new Engine($state, $repo, $persistence);

// 加载场景
$data = $engine->start($sceneId);


while (true) {
    echo "\n\n==============================\n\n人物属性:" . json_encode($data['player'], JSON_UNESCAPED_UNICODE) . "\n" . $data['description'] . "\n";
    if (empty($data['options'])) {
        echo "游戏结束。\n";
        break;
    }

    foreach ($data['options'] as $index => $opt) {
        echo "[" . ($index + 1) . "] " . $opt['label'] . "\n";
    }

    echo "请输入选项数字: ";
    $input = trim(fgets(STDIN));
    $choice = intval($input);
    if ($choice < 1 || $choice > count($data['options'])) {
        echo "无效选择，请重新输入。\n";
        continue;
    }

    $selectedKey = $data['options'][$choice - 1]['key'];
    echo $data['options'][$choice - 1]['desc'] . "\n";
    $data = $engine->choose($user_id, $selectedKey);
}
