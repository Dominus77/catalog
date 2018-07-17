<?php

namespace modules\catalog\models\query;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use modules\catalog\models\Category;

/**
 * Class CategoryQuery
 * @package modules\catalog\models\query
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
