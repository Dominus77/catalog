<?php

namespace modules\catalog\models;

use Yii;
use modules\catalog\Module;

/**
 * This is the model class for table "{{%catalog_promotion_product}}".
 *
 * @property int $promotion_id ID Promotion
 * @property int $product_id ID Product
 *
 * @property CatalogProduct $product
 * @property CatalogPromotion $promotion
 */
class CatalogPromotionProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_promotion_product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['promotion_id', 'product_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogProduct::class, 'targetAttribute' => ['product_id' => 'id']],
            [['promotion_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogPromotion::class, 'targetAttribute' => ['promotion_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'promotion_id' => Module::t('module', 'Promotion ID'),
            'product_id' => Module::t('module', 'Product ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(CatalogProduct::class, ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPromotion()
    {
        return $this->hasOne(CatalogPromotion::class, ['id' => 'promotion_id']);
    }
}
