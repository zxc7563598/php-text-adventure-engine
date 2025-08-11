# text-adventure-engine

> ⚠ **开发中**：当前版本尚未稳定，功能可能会有调整。  
> 目前处于基础功能开发阶段，仅供测试与预览使用。  
> 计划在完善后发布稳定版本，并附带完整 Demo。

一个轻量级、可扩展的 **PHP 文字冒险游戏核心引擎** Composer 包，  
专注于 **游戏流程管理** 和 **玩家状态维护**，帮助开发者快速搭建基于文字选择的冒险游戏。

## ✨ 特性

- **灵活的场景与选项系统** — 自由定义游戏分支与流程
- **内置玩家状态管理** — 轻松维护生命值、金币、背包等属性
- **可扩展的存档机制** — 支持文件、数据库、Redis 等多种持久化方案
- **易于集成** — 设计简单，几乎可以无缝嵌入任何 PHP 项目或框架

适合用于快速开发单人文字冒险游戏，或作为更复杂游戏的核心逻辑基础。

---

## 📦 安装

```bash
composer require hejunjie/text-adventure-engine
```

---

## 🛠 使用说明

### 1. 场景配置

游戏场景使用 JSON 格式定义，例如：

```json
{
  "start": {
    "id": "start", // 场景唯一 ID
    "description": "你站在一个岔路口，前方有两条路。",
    "options": [
      {
        "key": "go-left", // 选项唯一 ID
        "label": "走左边的小路", // 展示给玩家的文字
        "desc": "你选择了左边的小路。", // 选择后的描述
        "conditions": [ // 条件判断
          {
            "type": "always_true", // 无条件跳转
            "nextSceneId": "forest" // 跳转到的下一个场景 ID
          }
        ],
        "effects": [ // 选项的影响
          {
            "type": "change_attribute", // 改变属性值
            "key": "hp", // 生命值
            "value": -5 // 生命值减少 5
          }
        ]
      },
      {
        "key": "go-right",
        "label": "走右边的大路",
        "desc": "你选择了右边的大路。",
        "conditions": [
          {
            "type": "attribute_check", // 检查玩家属性
            "logic": [
              { "attribute": "gold", "operator": ">=", "value": 10 } // 金币 >= 10 才能进入
            ],
            "nextSceneId": "town"
          }
        ]
      }
    ]
  }
}
```

---

### 2. 开始游戏 / 加载存档

```php
use Hejunjie\TextAdventureEngine\Engine;
use Hejunjie\TextAdventureEngine\Persistence\FilePersistence;
use Hejunjie\TextAdventureEngine\PlayerState;
use Hejunjie\TextAdventureEngine\Repositories\JsonSceneRepository;

// 存档目录
$saveDir = __DIR__ . '/../save_data';
$persistence = new FilePersistence($saveDir);

// 模拟用户 ID
$user_id = 'game-1'; 

// 从文件加载存档
$save = $persistence->load($user_id);

if ($save) {
    // 如果有存档，恢复状态
    $state = $save['state'];
    $sceneId = $save['currentScene'];
} else {
    // 否则初始化新游戏
    $state = [];
    $sceneId = 'start';
}

// 初始化玩家状态
$state = new PlayerState($state, $sceneId);

// 从 JSON 文件中加载场景（也可实现数据库版）
$repo = new JsonSceneRepository('游戏场景.json');

// 构建游戏引擎
$engine = new Engine($state, $repo, $persistence);

// 输出当前场景信息
print_r($engine->start($sceneId));
```

---

### 3. 玩家做出选择

```php
// 让玩家选择某个选项（传入选项 key）
print_r($engine->choose($user_id, 'go-left'));
```

---

## 💡 提示

- ​`JsonSceneRepository` 仅作为示例，你可以替换为数据库实现
- ​`FilePersistence` 可替换为 Redis / MySQL 存储
- 属性、条件和效果类型都可以扩展

---

‍
