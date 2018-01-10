<?php

namespace modules\catalog\models\query;

use yii\db\ActiveQuery;
use modules\catalog\models\CatalogOrder;

/**
 * Class CatalogOrderQuery
 * @package modules\catalog\models\query
 */
class CatalogOrderQuery extends ActiveQuery
{
    /**
     * @param $timeout
     * @return $this
     */
    public function overdue($timeout)
    {
        return $this
            ->andWhere(['status' => CatalogOrder::STATUS_ORDER_DEFAULT])
            ->andWhere(['<', 'updated_at', time() - $timeout]);
    }

    /**
     * @inheritdoc
     * @return CatalogOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CatalogOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
