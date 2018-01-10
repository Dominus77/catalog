Yii 2 module Catalog and Cart
===============================

Модуль каталога товаров NestedSets с пользовательской корзиной.

> Модуль находится в разработке и пишется на шаблоне [Dominus77/yii2-advanced-start](https://github.com/Dominus77/yii2-advanced-start)

Установка
------------
Выполнить в корне приложения
```
git clone https://github.com/Dominus77/catalog.git modules/catalog
```
Подключение
------------
common\config\main.php
```
$config = [
    //...
    'modules' => [
        //...
        'catalog' => [
            'class' => 'modules\catalog\Module',
        ],
    ],
    //...
];
```
frontend\config\main.php
```
$config = [
    'bootstrap' => [
        //...
        'modules\catalog\Bootstrap',
    ],
    //...
];
```
backend\config\main.php
```
$config = [
    'bootstrap' => [
        //...
        'modules\catalog\Bootstrap',
    ],
    //...
];
```
console\config\main.php
```
$config = [
    'bootstrap' => [
        //...
        'modules\catalog\Bootstrap',
    ],
    //...
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'modules\catalog\migrations',
            ],
        ],
    ],
];
```
Применить миграции
---
```
php yii migrate
```
Ссылки
---
Определяются правилами в файле [Bootstrap.php](https://github.com/Dominus77/catalog/blob/master/Bootstrap.php)

License
-----
The BSD License (BSD). Please see [License File](https://github.com/Dominus77/catalog/blob/master/LICENSE.md) for more information.






