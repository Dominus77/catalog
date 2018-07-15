# Yii 2 module Catalog and Cart

Модуль каталога товаров NestedSets с пользовательской корзиной.

> Модуль находится в разработке и пишется на шаблоне [Dominus77/yii2-advanced-start](https://github.com/Dominus77/yii2-advanced-start)

## Установка

Выполнить в корне приложения
```
git clone https://github.com/Dominus77/catalog.git modules/catalog
```
Модуль использует следующие зависимости:

[creocoder/yii2-nested-sets](https://github.com/creocoder/yii2-nested-sets)

[yii2tech/ar-position](https://github.com/yii2tech/ar-position)

[dimmitri/yii2-expand-row-column](https://github.com/dimmitri/yii2-expand-row-column)

[moonlandsoft/yii2-phpexcel](https://github.com/moonlandsoft/yii2-phpexcel)

[2amigos/yii2-date-picker-widget](https://github.com/2amigos/yii2-date-picker-widget)

[2amigos/yii2-date-time-picker-widget](https://github.com/2amigos/yii2-date-time-picker-widget)

[kartik-v/yii2-widget-select2](https://github.com/kartik-v/yii2-widget-select2)

## Подключение

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
### Подключение виджета корзины
В главном шаблоне:
```
<?php $this->beginBody() ?>
// Подключаем виджет
<?= modules\catalog\widgets\shop\CartWidget::widget() ?>
```
## Применить миграции

```
php yii migrate
```
### Ссылки
frontend
```
/catalog/default/index
/shop/cart/index
```
backend
```
/admin/catalog/default/index
/admin/catalog/category/index
/admin/catalog/product/index
/admin/catalog/product-image/index
/admin/catalog/promotion/index
/admin/catalog/orders/index

```
Определяются правилами в файле [Bootstrap.php](https://github.com/Dominus77/catalog/blob/master/Bootstrap.php)

### License
The MIT License (MIT). Please see [License File](https://github.com/Dominus77/catalog/blob/master/LICENSE.md) for more information.
