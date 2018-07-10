<?php

namespace modules\catalog;

use yii\base\BootstrapInterface;
use yii\base\Application;

/**
 * Class Bootstrap
 * @package modules\catalog
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        $app->setComponents([
            'cart' => [
                'class' => 'modules\catalog\components\Cart'
            ],
        ]);

        // i18n
        $app->i18n->translations['modules/catalog/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/catalog/messages',
            'fileMap' => [
                'modules/catalog/module' => 'module.php',
            ],
        ];

        // Rules
        $app->getUrlManager()->addRules(
            [
                // Rules

                // Categories
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/category',
                    'prefix' => 'catalog',
                    'rules' => [
                        'categories' => 'index',
                        'category/<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        'category/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Product Image
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/product-image',
                    'prefix' => 'catalog/product',
                    'rules' => [
                        'images' => 'index',
                        'image/<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        'image/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Product
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/product',
                    'prefix' => 'catalog',
                    'rules' => [
                        'products' => 'index',
                        'products/import' => 'import',
                        'products/export' => 'export',
                        'product/<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        'product/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Orders products
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/orders-product',
                    'prefix' => 'shop/order',
                    'rules' => [
                        'products' => 'index',
                        'product/<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        'product/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Orders
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/orders',
                    'prefix' => 'shop',
                    'rules' => [
                        'orders' => 'index',
                        'order/<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        'order/<_a:[\w\-]+>' => '<_a>',
                    ],
                ],

                // Cart
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/cart',
                    'prefix' => 'shop/cart',
                    'rules' => [
                        '' => 'index',
                        '<id:\d+>/<_a:[\w\-]+>' => '<_a>',
                        '<_a:[\w\-]+>' => '<_a>',
                    ],
                ],
                // Frontend
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/default',
                    'prefix' => 'shop/catalog',
                    'rules' => [
                        '' => 'index',
                        '<_a:[\w\-]+>/<id:\d+>/<slug:[\w\-]+>' => '<_a>',
                    ],
                ],

                // Default
                [
                    'class' => 'yii\web\GroupUrlRule',
                    'routePrefix' => 'catalog/default',
                    'prefix' => 'catalog',
                    'rules' => [
                        '' => 'index',
                    ],
                ],
            ]
        );
    }
}
