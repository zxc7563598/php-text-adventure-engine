<?php

require __DIR__ . '/../vendor/autoload.php';

use Hejunjie\TextAdventureEngine\Engine;
use Hejunjie\TextAdventureEngine\Persistence\FilePersistence;
use Hejunjie\TextAdventureEngine\Scene;
use Hejunjie\TextAdventureEngine\Option;

$saveDir = __DIR__ . '/../save_data';
$persistence = new FilePersistence($saveDir);
$engine = new Engine($persistence);

// 定义场景
$start = new Scene('start', "你醒来了，发现自己在一间陌生的房间。");
$start->addOption(new Option('look', '环顾四周', 'look_scene'));
$start->addOption(new Option('sleep', '继续睡觉', 'sleep_scene'));

$lookScene = new Scene('look_scene', '你看到了一个门和一扇窗。');
$lookScene->addOption(new Option('open_door', '开门', 'outside', [
    ['type' => 'change_attribute', 'key' => 'hp', 'value' => -1],
]));
$lookScene->addOption(new Option('open_window', '开窗', 'window_view'));

$sleepScene = new Scene('sleep_scene', '你继续睡觉，游戏结束。');

$outside = new Scene('outside', '你走出了房间，阳光洒在脸上，游戏结束。');
$windowView = new Scene('window_view', '你透过窗看到外面的世界，游戏结束。');

foreach ([$start, $lookScene, $sleepScene, $outside, $windowView] as $scene) {
    $engine->addScene($scene);
}

echo "=== 文字冒险游戏 ===\n";
echo "玩家ID默认用 'player1'\n";

$playerId = 'player1';

// 启动或恢复游戏，默认从start开始
$data = $engine->startGame($playerId, 'start');

while (true) {
    echo "当前血量: " . ($data['playerState']['hp'] ?? 0) . "\n";
    echo "\n" . $data['description'] . "\n";
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
    $data = $engine->makeChoice($playerId, $selectedKey);
}