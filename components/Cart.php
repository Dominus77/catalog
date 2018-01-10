<?php

namespace modules\catalog\components;

use Yii;
use yii\base\Component;
use modules\catalog\models\CatalogOrder;
use modules\catalog\models\CatalogOrderProduct;
use modules\catalog\Module;

/**
 * Class Cart
 * @package modules\catalog\components
 * @property CatalogOrder $orders
 * @property string $status
 */
class Cart extends Component
{
    const SESSION_KEY = 'order_id';

    private $_order;

    /**
     * @param $productId
     * @param $count
     * @return bool
     */
    public function add($productId, $count)
    {
        $link = CatalogOrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->order->id]);
        if (!$link) {
            $link = new CatalogOrderProduct();
        }
        $link->product_id = $productId;
        $link->order_id = $this->order->id;
        $link->count += $count;
        return $link->save();
    }

    /**
     * @return bool
     */
    public function createOrder()
    {
        $order = new CatalogOrder();
        if ($order->save()) {
            $this->_order = $order;
            return true;
        }
        return false;
    }

    /**
     * @return null|static
     */
    public function getOrder()
    {
        if ($this->_order == null) {
            $this->_order = CatalogOrder::findOne(['id' => $this->getOrderId()]);
        }
        return $this->_order;
    }

    /**
     * @return mixed
     */
    private function getOrderId()
    {
        if (!Yii::$app->session->has(self::SESSION_KEY)) {
            if ($this->createOrder()) {
                Yii::$app->session->set(self::SESSION_KEY, $this->_order->id);
            }
        }
        return Yii::$app->session->get(self::SESSION_KEY);
    }

    /**
     * @param $productId
     * @return bool|false|int
     */
    public function deleteOrderProduct($productId)
    {
        $link = CatalogOrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
        if (!$link) {
            return false;
        }
        return $link->delete();
    }

    /**
     * @param $productId
     * @param $count
     * @return bool
     */
    public function setCount($productId, $count)
    {
        $link = CatalogOrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
        if (!$link) {
            return false;
        }
        $link->count = $count;
        return $link->save();
    }

    /**
     * @param $productId
     * @return bool|int
     */
    public function getCount($productId)
    {
        $link = CatalogOrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
        if (!$link) {
            return false;
        }
        return $link->count;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        if ($this->isEmpty()) {
            return Module::t('module', 'Your shopping cart is empty');
        }
        return Module::t('module', 'In the cart {productsCount, number} {productsCount, plural, one {commodity} few {goods} many {goods} other {goods}} for the amount of {amount} rub.', [
            'productsCount' => $this->order->productsCount,
            'amount' => $this->order->amount
        ]);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        if (!Yii::$app->session->has(self::SESSION_KEY)) {
            return true;
        }
        return $this->order->productsCount ? false : true;
    }

    /**
     * Clean session key
     */
    public function clean()
    {
        Yii::$app->session->remove(self::SESSION_KEY);
    }
}