<?php

namespace modules\catalog\components;

use Yii;
use yii\base\Component;
use modules\catalog\models\Order;
use modules\catalog\models\OrderProduct;
use modules\catalog\traits\ModuleTrait;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/**
 * Class Cart
 *
 * @package modules\catalog\components
 *
 * @property Order $orders
 * @property string $status
 * @property Order $order
 */
class Cart extends Component
{
    use ModuleTrait;

    const SESSION_KEY = 'order_id';

    private $_order;

    /**
     * @param $productId
     * @param $count
     * @return bool
     */
    public function add($productId, $count)
    {
        $link = OrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->order->id]);
        if (!$link) {
            $link = new OrderProduct();
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
        $order = new Order();
        if ($order->save()) {
            $this->_order = $order;
            return true;
        }
        return false;
    }

    /**
     * @return Order|null
     */
    public function getOrder()
    {
        if ($this->_order == null) {
            $this->_order = Order::findOne(['id' => $this->getOrderId()]);
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteOrderProduct($productId)
    {
        $link = OrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
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
        $link = OrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
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
        $link = OrderProduct::findOne(['product_id' => $productId, 'order_id' => $this->getOrderId()]);
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
