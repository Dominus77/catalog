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
Модуль использует следующие зависимости:

[creocoder/yii2-nested-sets](https://github.com/creocoder/yii2-nested-sets)

[yii2tech/ar-position](https://github.com/yii2tech/ar-position)

[dimmitri/yii2-expand-row-column](https://github.com/dimmitri/yii2-expand-row-column)

[moonlandsoft/yii2-phpexcel](https://github.com/moonlandsoft/yii2-phpexcel)

Подключение
------------
common\config\main.php
```
$config = [
    //...
    'modules' => [        
        'catalog' => [
            'class' => 'modules\catalog\Module',
        ],
        //...
    ],
    //...
    'components' => [
        'cart' => [
            'class' => 'modules\catalog\components\Cart',
        ],
        //...
    ],
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
    'modules' => [
        'catalog' => [
            'isBackend' => true,
        ],
    ],
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
                //...
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
frontend
```
/catalog
/shop/cart
```
backend
```
/admin/catalog
/admin/catalog/categories
/admin/catalog/products
/admin/catalog/product/images
/admin/shop/orders

```
Определяются правилами в файле [Bootstrap.php](https://github.com/Dominus77/catalog/blob/master/Bootstrap.php)

License
-----
The BSD License (BSD). Please see [License File](https://github.com/Dominus77/catalog/blob/master/LICENSE.md) for more information.






