<?php

namespace modules\catalog\controllers\backend;

use yii\web\Controller;
use yii\filters\AccessControl;
use modules\catalog\models\CatalogCategory;
use modules\catalog\models\CatalogProduct;
use modules\catalog\models\CatalogProductImage;
use modules\catalog\models\CatalogOrder;
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
            'category' => CatalogCategory::getCount(),
            'product' => CatalogProduct::getCount(),
            'image' => CatalogProductImage::getCount(),
            'order' => CatalogOrder::getCount(),
        ];
        return $this->render('index', [
            'counts' => $counts,
        ]);
    }
}
