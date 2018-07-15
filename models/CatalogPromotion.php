<?php

namespace modules\catalog\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
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
 * @property array $statusesArray
 * @property string $statusLabelName
 * @property string $startAt
 * @property string $endAt
 */
class CatalogPromotion extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISH = 1;

    public $products;

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
            [['discount', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            //[['start_at', 'end_at'], 'date', 'format' => 'dd.mm.yyyy H:ii'],
            [['startAt', 'endAt'], 'safe'],
            //['start_at', 'validateDates'],
        ];
    }

    /**
     * Validate dates range
     */
    public function validateDates()
    {
        if (strtotime($this->end_at) <= strtotime($this->start_at)) {
            $this->addError('start_at', 'Please give correct Start and End dates');
            $this->addError('end_at', 'Please give correct Start and End dates');
        }
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
            'products' => Module::t('module', 'Products'),
            'startAt' => Module::t('module', 'Start'),
            'endAt' => Module::t('module', 'End'),
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

    /**
     * @param $value
     */
    public function setStartAt($value)
    {
        $this->start_at = strtotime($value);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getStartAt()
    {
        return $this->start_at ? Yii::$app->formatter->asDatetime($this->start_at, 'php:d-m-Y H:i') : '';
    }

    /**
     * @param $value
     */
    public function setEndAt($value)
    {
        $this->end_at = strtotime($value);
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getEndAt()
    {
        return $this->end_at ? Yii::$app->formatter->asDatetime($this->end_at, 'php:d-m-Y H:i') : '';
    }

    /**
     * Set Status
     * @return int|string
     */
    public function setStatus()
    {
        switch ($this->status) {
            case self::STATUS_PUBLISH:
                $this->status = self::STATUS_DRAFT;
                break;
            default:
                $this->status = self::STATUS_PUBLISH;
        }
        return $this->status;
    }

    /**
     * @return int|string
     */
    public static function getCount()
    {
        return static::find()->count();
    }

    /**
     * @return ActiveDataProvider
     */
    public function getPromotionProducts()
    {
        $relations = $this->getCatalogPromotionProducts()->all();
        $productsId = ArrayHelper::getColumn($relations, 'product_id');
        $query = CatalogProduct::find()->where(['id' => $productsId]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $provider;
    }
}
