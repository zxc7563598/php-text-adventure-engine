<?php

require __DIR__ . '/../vendor/autoload.php';

use Hejunjie\TextAdventureEngine\Engine;
use Hejunjie\TextAdventureEngine\Persistence\FilePersistence;
use Hejunjie\TextAdventureEngine\Scene;
use Hejunjie\TextAdventureEngine\Option;
use Hejunjie\TextAdventureEngine\PlayerState;

$saveDir = __DIR__ . '/../save_data';
$persistence = new FilePersistence($saveDir);
$engine = new Engine($persistence);

$data = [
    [
        'id' => 'start',
        'description' => '你在枯萎的林间小径发现一个受伤的猎人，他的腿被捕兽夹困住，痛苦呻吟。不远处，几只饥饿的变异狼在徘徊嗅探。你只有一把小刀',
        'options' => [
            [
                'key' => 'step1-1',
                'label' => '冒险引开狼群，尝试解救猎人',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-2']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 2]
                ]
            ],
            [
                'key' => 'step1-2',
                'label' => '利用猎人作为诱饵，自己悄悄绕路离开',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-2']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -3]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-2',
        'description' => '一个废弃的哨卡横在必经之路上。里面可能有补给，但入口有明显的陷阱痕迹和血迹。你注意到一个瞭望塔似乎有微弱的反光',
        'options' => [
            [
                'key' => 'step2-1',
                'label' => '极其小心地搜索外围，优先检查瞭望塔',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-3']
                ],
                'effects' => []
            ],
            [
                'key' => 'step2-2',
                'label' => '制造噪音（如扔石头）触发可能的陷阱，再进入',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-3']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -1]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-3',
        'description' => '进入一个死寂的小镇。唯一的声音是一个躲在破屋角落里哭泣的小男孩。他抱着一个不会动的玩具机器人，父母在灾变初期的混乱中失踪',
        'options' => [
            [
                'key' => 'step3-1',
                'label' => '安慰他，带上他一起走，承诺帮他寻找亲人或安全',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-4']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 2]
                ]
            ],
            [
                'key' => 'step3-2',
                'label' => '留下少量食物和水，告诉他去镇子另一头的“安全屋”（可能不存在），自己快速离开',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-4']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -1]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-4',
        'description' => '你终于找到一小片未完全干涸的泥潭。一个疲惫的母亲带着孩子正在取水，看到你后立刻举起了生锈的手枪，手在发抖',
        'options' => [
            [
                'key' => 'step4-1',
                'label' => '慢慢放下武器（如果有），摊开双手，表示只想分享一点水并休息',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-5']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 1]
                ]
            ],
            [
                'key' => 'step4-2',
                'label' => '迅速拔枪（如果有）或寻找掩体，威慑对方离开水源',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-5']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -2]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-5',
        'description' => '你被一伙掠夺者拦截，领头者竟是你灾变前的同事莉娜。她认出了你，也看到了你背包里露出的“启明石”微光。她提出“合作”：交出石头，加入他们成为二把手',
        'options' => [
            [
                'key' => 'step5-1',
                'label' => '严词拒绝，斥责她的背叛，试图唤醒她过去的理想',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-6']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 1]
                ]
            ],
            [
                'key' => 'step5-2',
                'label' => '假意同意，伺机偷取或破坏他们的重要物资后逃跑/反击',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-6']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -2]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-6',
        'description' => '在一个破败的图书馆，你遇到一位垂死的老学者。他知道“启明石”的传说，警告它既是钥匙也是炸弹，取决于使用者的“心之光”。他恳求你带走他毕生研究的手稿（很重），里面有控制/安全使用的线索。',
        'options' => [
            [
                'key' => 'step6-1',
                'label' => '答应带走手稿，并尽力照顾他最后一程',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-7']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 3]
                ]
            ],
            [
                'key' => 'step6-2',
                'label' => '记下关键信息，婉拒带走沉重的手稿',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-7']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -1]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-7',
        'description' => '必经之路上有一个被“静默热”瘟疫笼罩的村庄。中心小屋传出痛苦的咳嗽声。村口木牌写着警告和绝望的留言',
        'options' => [
            [
                'key' => 'step7-1',
                'label' => '用能找到的布料捂住口鼻，冒险进入查看是否有幸存者或关键信息',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-8']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 2]
                ]
            ],
            [
                'key' => 'step7-2',
                'label' => '将身上仅有的草药放在村口，快速绕行最远的路离开',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-8']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 1]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-8',
        'description' => '一条深不见底的峡谷挡住去路。唯一可行的是一座摇摇欲坠的吊桥。一群自称“守桥人”的武装者要求过桥者交出“启明石”作为“通行费”或完成一项极其危险的任务（下到峡谷底取回某物）',
        'options' => [
            [
                'key' => 'step8-1',
                'label' => '尝试谈判，分享有价值的信息（如瘟疫村位置、学者笔记内容）替代石头',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-9']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 1]
                ]
            ],
            [
                'key' => 'step8-2',
                'label' => '寻找机会突袭/暗杀守卫头领，强行过桥',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-9']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 3]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-9',
        'description' => '一个衣着体面、自称来自“复兴委员会”的特工找到你。他展示了一些高科技设备（在静默灾变中罕见），声称“启明石”是他们遗失的“世界引擎核心”，承诺给你一个安全的未来和领导地位换取它。他暗示拒绝的“后果”',
        'options' => [
            [
                'key' => 'step9-1',
                'label' => ' 拒绝，坚信石头应服务于更广大幸存者的未来，而非某个组织',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-10']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => 3]
                ]
            ],
            [
                'key' => 'step9-2',
                'label' => '假意同意，计划在交易时夺取对方的科技装备',
                'conditions' => [
                    ['condition' => fn() => true, 'nextSceneId' => 'setp-10']
                ],
                'effects' => [
                    ['type' => 'change_attribute', 'key' => 'conscience', 'value' => -3]
                ]
            ]
        ]
    ],
    [
        'id' => 'setp-10',
        'description' => '历经艰险，你到达了地图标记的“静默核心”——一个巨大的、死寂的环形山，中央有一座奇异的、半嵌入地下的装置。“启明石”在你手中发出共鸣。装置前站着莉娜（若第5回合未解决）或复兴委员会特工（若第9回合未解决）或他们的残部，虎视眈眈。装置控制台亮起，似乎需要放入石头并做出最终选择',
        'options' => [
            [
                'key' => 'step10-1',
                'label' => '高举“启明石”，走向控制台，心中默念为所有人争取希望',
                'conditions' => [
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= 12, 'nextSceneId' => 'final-1'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= 0, 'nextSceneId' => 'final-2'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= -11, 'nextSceneId' => 'final-3'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') < -11, 'nextSceneId' => 'final-4']
                ],
                'effects' => []
            ],
            [
                'key' => 'step10-2',
                'label' => '紧握“启明石”，警惕地环视敌人，准备为生存而战/谈判',
                'conditions' => [
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= 12, 'nextSceneId' => 'final-1'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= 0, 'nextSceneId' => 'final-2'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') >= -11, 'nextSceneId' => 'final-3'],
                    ['condition' => fn(PlayerState $state) => $state->getAttribute('conscience') < -11, 'nextSceneId' => 'final-4']
                ],
                'effects' => []
            ]
        ]
    ],
    [
        'id' => 'final-1',
        'description' => '你无私的选择汇聚成强大的“心之光”。“启明石”被安全激活，装置发出柔和的脉冲，枯萎的大地开始萌发微弱绿意，停滞的机器发出低鸣。你不是统治者，而是希望的象征。幸存者们自发聚集在你带来的生机周围，一个基于互助与重建的新时代艰难开启。莉娜/特工要么被感化，要么被幸存者的希望浪潮淹没',
        'options' => []
    ],
    [
        'id' => 'final-2',
        'description' => '你的善良在黑暗中点亮了微光。“启明石”被激活，但效果有限，可能只净化了小片区域或稳定了装置。绿洲诞生，但依然脆弱。你可能是其中的一位领导者或守护者，世界依然艰难，但你证明了人性未泯。莉娜/特工可能被击退或达成脆弱协议，威胁仍在',
        'options' => []
    ],
    [
        'id' => 'final-3',
        'description' => '你活下来了，代价是灵魂的磨损。“启明石”可能被激活（效果不稳定），或被你用来交易换取个人安全区/权力。你得到了庇护和地位，但周围是猜忌、奴役或强权统治。绿洲或许存在，但冰冷无情。莉娜/特工可能成为你的同伙或新的敌人。夜晚，过去的阴影会萦绕心头',
        'options' => []
    ],
    [
        'id' => 'final-4',
        'description' => '你被黑暗彻底吞噬。你可能强行激活“启明石”导致灾难性爆炸/吞噬，或用它向莉娜/特工换取毁灭性的力量，成为新的掠夺霸主。世界滑向更深的深渊，你统治的“绿洲”是绝望的牢笼。人性之光在你身上彻底熄灭，你成为了“静默灾变”最可怕的产物',
        'options' => []
    ]
];

// 定义场景
foreach ($data as $_data) {
    $scene = new Scene($_data['id'], $_data['description']);
    foreach ($_data['options'] as $option) {
        $scene->addOption(new Option(
            $option['key'],
            $option['label'],
            $option['conditions'] ?? [],
            $option['effects'] ?? []
        ));
    }
    $engine->addScene($scene);
}

echo "=== 文字冒险游戏 ===\n";
echo "玩家ID默认用 'player1'\n";

$playerId = 'player1';

// 启动或恢复游戏，默认从start开始
$data = $engine->startGame($playerId, 'start');

while (true) {
    echo "\n\n==============================\n\n" . $data['description'] . "\n";
    if (empty($data['options'])) {
        echo "\n善恶值" . ($data['playerState']['conscience'] ?? 0) . "\n游戏结束。\n";
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
