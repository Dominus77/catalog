<?php

namespace modules\catalog\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use modules\catalog\Module;

/**
 * This is the model class for table "{{%catalog_promotion}}".
 *
 * @property int $id
 * @property string $name Name
 * @property string $description Description
 * @property int $discount Discount
 * @property int $status Status
 * @property int $start_at Start
 * @property int $end_at End
 * @property int $created_at Created
 * @property int $updated_at Updated
 *
 * @property CatalogPromotionProduct[] $catalogPromotionProducts
 */
class CatalogPromotion extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISH = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%catalog_promotion}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['discount', 'status', 'start_at', 'end_at', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ID'),
            'name' => Module::t('module', 'Name'),
            'description' => Module::t('module', 'Description'),
            'discount' => Module::t('module', 'Discount'),
            'status' => Module::t('module', 'Status'),
            'start_at' => Module::t('module', 'Start'),
            'end_at' => Module::t('module', 'End'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogPromotionProducts()
    {
        return $this->hasMany(CatalogPromotionProduct::class, ['promotion_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_DRAFT => Module::t('module', 'Draft'),
            self::STATUS_PUBLISH => Module::t('module', 'Published'),
        ];
    }

    /**
     * @return array
     */
    public static function getLabelsArray()
    {
        return [
            self::STATUS_DRAFT => 'default',
            self::STATUS_PUBLISH => 'success',
        ];
    }

    /**
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->status);
    }

    /**
     * Return <span class="label label-success">Active</span>
     * @return string
     */
    public function getStatusLabelName()
    {
        $name = ArrayHelper::getValue(self::getLabelsArray(), $this->status);
        return Html::tag('span', self::getStatusName(), ['class' => 'label label-' . $name]);
    }
}
