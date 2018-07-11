<?php

namespace modules\catalog\widgets\shop;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
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
     * Возвращает количество продуктов в заказе со статусом Default
     * @return mixed
     */
    protected function getCounter()
    {
        $orderProducts = $this->getCatalogOrderDefaultProducts()
            ->select('count')
            ->indexBy('count')
            ->column();
        return ArrayHelper::getValue($orderProducts, function ($orderProducts, $defaultValue) {
            foreach ($orderProducts as $value) {
                $defaultValue += $value;
            }
            return $defaultValue;
        });
    }

    /**
     * Возвращает продукты заказа со статусом Default
     * @return int|string|\yii\db\ActiveQuery
     */
    protected function getCatalogOrderDefaultProducts()
    {
        $id = Yii::$app->cart->order->id;
        $order = CatalogOrder::findOne([
            'id' => $id,
            'status' => CatalogOrder::STATUS_ORDER_DEFAULT
        ]);
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
