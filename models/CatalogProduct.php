<?php

namespace modules\catalog\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\helpers\VarDumper;
use yii2tech\ar\position\PositionBehavior;
use modules\catalog\Module;

/**
 * This is the model class for table "{{%catalog_product}}".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $slug
 * @property string $availability
 * @property string $retail
 * @property string $description
 * @property integer $category_id
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property CatalogCategory $category
 * @property CatalogProductImage[] $catalogProductImages
 * @property CatalogPromotionProduct[] $catalogProductPromotion
 */
class CatalogProduct extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISH = 1;

    private $_promotion;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_product}}';
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
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
            ],
            'positionBehavior' => [
                'class' => PositionBehavior::class,
                'positionAttribute' => 'position',
                'groupAttributes' => [
                    'category_id',
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
            [['name', 'category_id', 'code'], 'required'],
            [['description'], 'string'],
            [['category_id', 'position', 'created_at', 'updated_at', 'status', 'promotion'], 'integer'],
            [['availability'], 'integer'],
            [['retail'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['code', 'name', 'slug'], 'string', 'max' => 255],
            [['meta_description'], 'string', 'max' => 200],
            [['meta_keywords'], 'string', 'max' => 250],
            [['slug'], 'unique'],
            [['code'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ID'),
            'code' => Module::t('module', 'Code'),
            'name' => Module::t('module', 'Name'),
            'slug' => Module::t('module', 'Alias'),
            'availability' => Module::t('module', 'Availability'),
            'retail' => Module::t('module', 'Retail'),
            'description' => Module::t('module', 'Description'),
            'category_id' => Module::t('module', 'Category'),
            'position' => Module::t('module', 'Position'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
            'status' => Module::t('module', 'Status'),
            'meta_description' => Module::t('module', 'Meta-description'),
            'meta_keywords' => Module::t('module', 'Meta-keywords'),
            'promotion' => Module::t('module', 'Promotion'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CatalogCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProductImages()
    {
        return $this->hasMany(CatalogProductImage::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductImages()
    {
        return $this->getCatalogProductImages()
            ->where(['status' => CatalogProductImage::STATUS_PUBLISH])
            ->orderBy(['position' => SORT_ASC]);
    }

    /**
     * @return \yii\db\ActiveQuery|CatalogPromotionProduct
     */
    public function getCatalogProductPromotion()
    {
        return $this->hasOne(CatalogPromotionProduct::class, ['product_id' => 'id']);
    }

    /**
     * @param null $id
     * @return array|null
     */
    public function getImages($id = null)
    {
        $model = new CatalogProductImage();
        $id = $id ? $id : $this->id;
        $dir = $model->getDir($id);
        if ($images = $this->productImages) {
            $pictures = [];
            foreach ($images as $value) {
                $pictures[] = '/' . $dir . $value->image;
            }
            return $pictures;
        }
        return null;
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
     * @return int|string
     */
    public static function getCount()
    {
        return static::find()->count();
    }

    /**
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public function getProductsAll()
    {
        $model = new CatalogProduct();
        $query = $model->find()
            ->orderBy(['position' => SORT_ASC])
            ->all();
        return $query;
    }

    /**
     * @return ActiveDataProvider
     */
    public function getPublishedProducts()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CatalogProduct::find()->where(['status' => self::STATUS_PUBLISH]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $dataProvider;
    }

    /**
     * @return array
     */
    public function getSelectArray()
    {
        if ($query = self::getProductsAll()) {
            $array = ArrayHelper::map($query, 'id', 'name');
        } else {
            $array = ['' => Module::t('module', '- Select product -')];
        }
        return $array;
    }

    /**
     * Return categories
     * @return array
     */
    public function getCategoriesTreeArray()
    {
        $model = new CatalogCategory();
        return $model->getSelectArray();
    }

    /**
     * @param $provider
     * @param $fieldName1
     * @param $fieldName2
     * @return float|int
     */
    public static function getTotal($provider, $fieldName1, $fieldName2)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$fieldName1] * $item[$fieldName2];
        }
        return $total;
    }

    /**
     * Добавление позиций
     * @param array $data
     * @return bool
     */
    public function importItemsCreate($data = [])
    {
        if ($data) {
            foreach ($data as $item) {
                if (!CatalogProduct::find()->where(['code' => $item['code']])->one()) {
                    $model = new CatalogProduct();
                    if ($model->load($item, '')) {
                        $model->code = (string)$item['code'];
                        if ($model->validate()) {
                            $model->save();
                        } else {
                            VarDumper::dump($model->errors, 10, 1);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Обновление позиций
     * @param array $data
     * @return bool
     */
    public function importItemsUpdate($data = [])
    {
        if ($data) {
            foreach ($data as $item) {
                if ($model = CatalogProduct::find()->where(['code' => $item['code']])->one()) {
                    if ($model->load($item, '')) {
                        $model->code = (string)$item['code'];
                        if ($model->validate()) {
                            $model->save();
                        } else {
                            VarDumper::dump($model->errors, 10, 1);
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function importItemsDelete($data = [])
    {
        if ($data) {
            if ($products = CatalogProduct::find()->select(['code'])->all()) {
                if (count($products) > count($data)) {
                    $dbCode = [];
                    foreach ($products as $product) {
                        $dbCode[] = $product->code;
                    }
                    $fileCode = [];
                    foreach ($data as $item) {
                        $fileCode[] = $item['code'];
                    }
                    $diff = array_diff($dbCode, $fileCode);
                    foreach ($diff as $key => $value) {
                        $product = CatalogProduct::find()->where(['code' => $value])->one();
                        $product->delete();
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Приводим данные к нужному формату
     * @param array $data
     * @return array
     */
    public function processPreparationImportData($data = [])
    {
        $newArrayData = [];
        if ($data) {
            if ($data = $this->processDeleteImportEmptyRows($data)) {
                foreach ($data as $item) {
                    $newData = $this->processImportModelAttributes($item); // Заменяем ключи атрибутами из модели
                    $newData['category_id'] = $this->processImportCategoryID($newData['category_id']); // Приводим в порядок строку category_id
                    $newArrayData[] = $newData;
                }
            }
        }
        return $newArrayData;
    }

    /**
     * Удаляет в импорте пустые строки
     * @param array $data
     * @param array $symbols
     * @return array
     */
    protected function processDeleteImportEmptyRows($data = [], $symbols = ['', null])
    {
        if ($data) {
            $result = [];
            foreach ($data as $rows) {
                $result[] = array_diff($rows, $symbols);
            }
            return array_values(array_filter($result));
        }
        return $data;
    }

    /**
     * Работа с атрибутами модели и атрибутами импортированных данных
     * Подготавливает массив импортированных данных для автозаполнения в модель
     * @param $data
     * @return array
     */
    protected function processImportModelAttributes($data)
    {
        $attributes = array_flip($this->attributeLabels());
        $attr = [];
        foreach ($data as $key => $value) {
            $attr[$value] = $attributes[$key];
        }
        $result = array_flip($attr);
        return $result;
    }

    /**
     * Работа со строкой category_id
     * строку "9 (название категории)" обрезает до "9"
     * @param $string
     * @return mixed
     */
    protected function processImportCategoryID($string)
    {
        $array = explode(' ', trim($string));
        $array = array_diff($array, ['']);
        return (int)$array[0];
    }

    /**
     * @return array
     */
    public function getPromotionsArray()
    {
        $model = CatalogPromotion::find()
            ->where(['status' => CatalogPromotion::STATUS_PUBLISH])
            ->all();
        $promotions = ArrayHelper::map($model, 'id', 'name');
        return $promotions;
    }

    /**
     * @param integer $promotionId
     */
    public function setPromotion($promotionId)
    {
        $this->_promotion = $promotionId;
    }

    /**
     * @return mixed
     */
    public function getPromotion()
    {
        $productPromotion = $this->getCatalogProductPromotion()->one();
        return $productPromotion->promotion_id;
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Удаляем изображения товара
        foreach (CatalogProductImage::find()->where(['product_id' => $this->id])->all() as $image) {
            $image->delete();
        }
        return true;
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($this->_promotion)) {
            CatalogPromotionProduct::deleteAll(['product_id' => $this->id]);
            self::getDb()->createCommand()
                ->insert(CatalogPromotionProduct::tableName(), ['product_id' => $this->id, 'promotion_id' => $this->_promotion])->execute();
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
