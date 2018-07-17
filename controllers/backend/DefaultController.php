<?php

namespace modules\catalog\controllers\backend;

use yii\web\Controller;
use yii\filters\AccessControl;
use modules\catalog\models\Category;
use modules\catalog\models\Product;
use modules\catalog\models\ProductImage;
use modules\catalog\models\Order;
use modules\catalog\Module;

/**
 * Class DefaultController
 * @package modules\catalog\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $counts = [
            'category' => Category::getCount(),
            'product' => Product::getCount(),
            'image' => ProductImage::getCount(),
            'order' => Order::getCount(),
        ];
        return $this->render('index', [
            'counts' => $counts,
        ]);
    }
}
