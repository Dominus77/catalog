<?php

namespace modules\catalog\widgets\shop;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use modules\catalog\models\CatalogOrder;

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
        return $this->getCatalogOrderDefaultProducts()->getProductsCount();
    }

    /**
     * Возвращает продукты заказа со статусом Default
     * @return CatalogOrder|null
     */
    protected function getCatalogOrderDefaultProducts()
    {
        $id = Yii::$app->cart->order->id;
        return CatalogOrder::findOne([
            'id' => $id,
            'status' => CatalogOrder::STATUS_ORDER_DEFAULT
        ]);
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
