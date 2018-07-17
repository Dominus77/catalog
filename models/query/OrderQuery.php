<?php

namespace modules\catalog\models\query;

use yii\db\ActiveQuery;
use modules\catalog\models\Order;

/**
 * Class OrderQuery
 * @package modules\catalog\models\query
 */
class OrderQuery extends ActiveQuery
{
    /**
     * @param $timeout int
     * @return $this
     */
    public function overdue($timeout)
    {
        return $this
            ->andWhere(['status' => Order::STATUS_ORDER_DEFAULT])
            ->andWhere(['<', 'updated_at', time() - $timeout]);
    }

    /**
     * @inheritdoc
     * @return Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
