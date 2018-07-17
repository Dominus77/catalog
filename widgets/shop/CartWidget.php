<?php

namespace modules\catalog\widgets\shop;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use modules\catalog\models\Order;

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
     * Возвращает количество продуктов в заказе
     * @return mixed
     */
    protected function getCounter()
    {
        if($products = $this->getCatalogOrderDefaultProducts()) {
            return $products->getProductsCount();
        }
        return 0;
    }

    /**
     * Возвращает продукты заказа со статусом Default
     * @return Order|null
     */
    protected function getCatalogOrderDefaultProducts()
    {
        if ($id = Yii::$app->cart->order->id) {
            return Order::findOne([
                'id' => $id,
                'status' => Order::STATUS_ORDER_DEFAULT
            ]);
        }
        return null;
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
