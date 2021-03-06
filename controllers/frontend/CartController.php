<?php

namespace modules\catalog\controllers\frontend;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use modules\catalog\models\Order;
use modules\catalog\models\form\BuyProductForm;
use yii\filters\VerbFilter;
use modules\catalog\Module;

/**
 * Class CartController
 * @package modules\catalog\controllers\frontend
 */
class CartController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add-in-cart' => ['post'],
                    'set-count' => ['post'],
                    'delete-from-cart' => ['post'],
                    'clean' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $id = Yii::$app->cart->order->id;
        $order = Order::find()->where(['id' => $id])->one();
        $dataProvider = new ActiveDataProvider([
            'query' => $order->getCatalogOrderProducts(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $formProduct = new BuyProductForm();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'formProduct' => $formProduct,
            'order' => $order,
        ]);
    }

    /**
     * @param $id
     * @return array|\yii\web\Response
     */
    public function actionAddInCart($id)
    {
        $formProduct = new BuyProductForm();
        if ($formProduct->load(Yii::$app->request->post()) && $formProduct->validate()) {
            Yii::$app->cart->add($id, $formProduct->count);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * @param $id
     * @return array|\yii\web\Response
     */
    public function actionSetCount($id)
    {
        $formProduct = new BuyProductForm();
        if ($formProduct->load(Yii::$app->request->post()) && $formProduct->validate()) {
            Yii::$app->cart->setCount($id, $formProduct->count);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeleteFromCart($id)
    {
        Yii::$app->cart->deleteOrderProduct($id);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionClean()
    {
        Yii::$app->cart->clean();
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
