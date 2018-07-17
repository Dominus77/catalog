<?php

namespace modules\catalog\controllers\frontend;

use Yii;
use yii\web\Controller;
use modules\catalog\models\Category;
use modules\catalog\models\Product;
use modules\catalog\models\form\BuyProductForm;
use yii\web\NotFoundHttpException;
use modules\catalog\Module;

/**
 * Class DefaultController
 * @package modules\catalog\controllers\frontend
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new Category();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Вывод всех товаров из родительской категории включая дочерние
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($id)
    {
        $model = $this->findCategoryModel($id);
        $formProduct = new BuyProductForm();
        return $this->render('category', [
            'model' => $model,
            'formProduct' => $formProduct,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProduct($id)
    {
        $model = $this->findProductModel($id);
        $formProduct = new BuyProductForm();
        return $this->render('product', [
            'model' => $model,
            'formProduct' => $formProduct,
        ]);
    }

    /**
     * @param $id
     * @return array|Category|null
     * @throws NotFoundHttpException
     */
    protected function findCategoryModel($id)
    {
        if (($model = Category::find()
                ->where(['id' => $id])
                ->andWhere(['status' => Category::STATUS_PUBLISH])
                ->one()) !== null
        ) {
            return $model;
        } else {
            throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
        }
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws NotFoundHttpException
     */
    protected function findProductModel($id)
    {
        $model = Product::find()
            ->where(['id' => $id])
            ->andWhere(['status' => Product::STATUS_PUBLISH])
            ->one();
        /** @var $model Product */
        if ($model !== null && $model->category->status === Category::STATUS_PUBLISH) {
            return $model;
        }
        throw new NotFoundHttpException(Module::t('module', 'The requested page does not exist.'));
    }
}
