<?php

namespace modules\catalog\widgets\shop;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use modules\catalog\models\CatalogOrder;
use modules\catalog\models\form\BuyProductForm;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

/**
 * Class CartWidget
 * @package modules\catalog\widgets\shop
 */
class CartWidget extends Widget
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->id = $this->id ? $this->id : $this->getId();
    }

    /**
     * @return string|void
     */
    public function run()
    {
        if ($this->status === true) {
            $this->registerAssets();
            echo Html::beginTag('div', ['id' => $this->id]) . PHP_EOL;
            echo $this->render('cartWidget', [
                    'count' => $this->getCounter(),
                ]) . PHP_EOL;
            echo Html::endTag('div') . PHP_EOL;
        }
    }

    /**
     * @return int|mixed
     */
    protected function getCounter()
    {
        $orderProducts = $this->getCatalogOrderProducts()->all();
        $count = 0;
        foreach ($orderProducts as $value) {
            $count += $value->count;
        }
        return $count;
    }

    /**
     * @return int|string|\yii\db\ActiveQuery
     */
    protected function getCatalogOrderProducts()
    {
        $id = Yii::$app->cart->order->id;
        $order = CatalogOrder::findOne(['id' => $id]);
        return $order->getCatalogOrderProducts();
    }

    /**
     * Register resource
     */
    private function registerAssets()
    {
        $view = $this->getView();
        CartAsset::register($view);
    }
}
