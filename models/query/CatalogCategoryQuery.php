<?php

namespace modules\catalog\models\query;

use yii\db\ActiveQuery;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use modules\catalog\models\CatalogCategory;

/**
 * Class CatalogCategoryQuery
 * @package modules\catalog\models\query
 */
class CatalogCategoryQuery extends ActiveQuery
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CatalogCategory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CatalogCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
