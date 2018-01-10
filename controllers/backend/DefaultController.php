<?php

namespace modules\catalog\controllers\backend;

use yii\web\Controller;
use yii\filters\AccessControl;
use modules\catalog\models\CatalogCategory;
use modules\catalog\models\CatalogProduct;
use modules\catalog\models\CatalogProductImage;
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
                'class' => AccessControl::className(),
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
        $category = new CatalogCategory();
        $product = new CatalogProduct();
        $image = new CatalogProductImage();
        return $this->render('index', [
            'category' => $category->getCategoriesAll(),
            'product' => $product->getProductsAll(),
            'image' => $image->getImagesAll(),
        ]);
    }
}
