<?php

namespace modules\catalog\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\position\PositionBehavior;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%catalog_product_image}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $image
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property CatalogProduct $product
 */
class CatalogProductImage extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISH = 1;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_product_image}}';
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
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'position',
                'groupAttributes' => [
                    'product_id',
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'position', 'created_at', 'updated_at', 'status'], 'integer'],
            [['image'], 'string', 'max' => 255],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogProduct::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['image', 'product_id', 'created_at', 'updated_at', 'position', 'status'];
        $scenarios[self::SCENARIO_UPDATE] = ['image', 'product_id', 'updated_at', 'position', 'status'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ID'),
            'product_id' => Module::t('module', 'Product'),
            'image' => Module::t('module', 'Image'),
            'position' => Module::t('module', 'Position'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
            'status' => Module::t('module', 'Status'),
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
     * Return categories
     * @return array
     */
    public function getProductsArray()
    {
        $model = new CatalogProduct();
        return $model->getSelectArray();
    }

    /**
     * @param null $dir
     * @return string
     */
    public function getDir($dir=null)
    {
        $dir = $dir ? $dir : $this->product_id;
        return Module::$uploadDir . '/' . $dir . '/';
    }

    /**
     * @param null $image
     * @return string
     */
    public function getCellImage($image=null)
    {
        $image = $image ? $image : $this->image;
        return '/'.$this->getDir() . $image;
    }

    /**
     * @return int|string
     */
    public static function getCount()
    {
        return static::find()->count();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getImagesAll()
    {
        $model = new CatalogProductImage();
        $query = $model->find()
            ->orderBy(['product_id' => SORT_ASC, 'position' => SORT_ASC])
            ->all();
        return $query;
    }

    /**
     * Действия перед удалением
     * @return bool
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        if ($this->image) {
            $uploadModel = new UploadForm([
                'dir' => $this->getDir(),
                'oldFile' => $this->image,
            ]);
            $uploadModel->delete();
        }
        return true;
    }
}
