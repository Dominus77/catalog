<?php

namespace modules\catalog\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use modules\catalog\models\query\CategoryQuery;
use yii\data\ActiveDataProvider;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%catalog_category}}".
 *
 * @property integer $id
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * @property Product[] $catalogProduct
 * @property string $statusLabelName
 * @property Category $rootCategory
 */
class Category extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISH = 1;
    const STATUS_DELETED = 2;

    const SCENARIO_CREATE = 'categoryCreate';
    const SCENARIO_UPDATE = 'categoryUpdate';
    const SCENARIO_MOVE = 'categoryMove';

    const POSITION_AFTER = 'after';
    const POSITION_BEFORE = 'before';

    public $parent;
    public $child;
    public $position;
    public $products;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_category}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 80],

            [['status'], 'in', 'range' => [self::STATUS_PUBLISH, self::STATUS_DRAFT, self::STATUS_DELETED]],

            [['description'], 'string'],

            //[['slug'], 'unique'],
            [['slug'], 'string', 'max' => 255],

            [['meta_description'], 'string', 'max' => 200],
            [['meta_keywords'], 'string', 'max' => 250],

            [['parent'], 'integer'],

            [['position'], 'in', 'range' => [self::POSITION_AFTER, self::POSITION_BEFORE]],

            [['child'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['parent', 'name', 'slug', 'description', 'created_at', 'updated_at', 'status', 'meta_description', 'meta_keywords'];
        $scenarios[self::SCENARIO_UPDATE] = ['name', 'slug', 'description', 'created_at', 'updated_at', 'status', 'meta_description', 'meta_keywords'];
        $scenarios[self::SCENARIO_MOVE] = ['parent', 'child', 'position'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ID'),
            'lft' => Module::t('module', 'L.Key'),
            'rgt' => Module::t('module', 'R.Key'),
            'depth' => Module::t('module', 'Depth'),
            'name' => Module::t('module', 'Name'),
            'slug' => Module::t('module', 'Alias'),
            'description' => Module::t('module', 'Description'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
            'status' => Module::t('module', 'Status'),
            'meta_description' => Module::t('module', 'Meta-description'),
            'meta_keywords' => Module::t('module', 'Meta-keywords'),
            'parent' => Module::t('module', 'Parent'),
            'position' => Module::t('module', 'Position'),
            'child' => Module::t('module', 'Child'),
            'products' => Module::t('module', 'Products'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * @param string $variations
     * @return string
     */
    public function getProductsCount($variations = 'default')
    {
        $count = count($this->getCatalogProducts()->all());
        return $count ? Html::a(Html::tag('span', $count, [
            'class' => 'label label-' . $variations,
        ]), ['products', 'id' => $this->id], [
            'title' => Module::t('module', 'Products'),
            'data' => [
                'toggle' => 'tooltip',
                'placement' => 'right',
                'pjax' => 0,
            ],
        ]) : '';
    }

    /**
     * @return int|string
     */
    public static function getCount()
    {
        return static::find()->count();
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_DRAFT => Module::t('module', 'Draft'),
            self::STATUS_PUBLISH => Module::t('module', 'Published'),
            self::STATUS_DELETED => Module::t('module', 'Deleted'),
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
            self::STATUS_DELETED => 'danger',
        ];
    }

    /**
     * @return array
     */
    public static function getMovePositionsArray()
    {
        return [
            self::POSITION_BEFORE => Module::t('module', 'Before'),
            self::POSITION_AFTER => Module::t('module', 'After'),
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
     * @return bool
     */
    public function isPublish()
    {
        return $this->status === self::STATUS_PUBLISH;
    }

    /**
     * @return bool
     */
    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * @return array|bool
     */
    public function getSelectArray()
    {
        $array = [];
        if ($query = self::getCategoriesAll()) {
            foreach ($query as $n => $category) {
                $depth = '';
                for ($i = 0; $i < $category->depth; $i++) {
                    $depth .= '- ';
                }
                $array[$category->id] = $depth . Html::encode($category->name);
            }
        } else {
            $array = ['0' => Module::t('module', '- Select category -')];
        }
        return $array;
    }

    /**
     * @return string
     */
    public function getStringTreePath()
    {
        $parents = $this->parents()->all();
        $string = '/';
        foreach ($parents as $category) {
            if ($category->depth > 0) {
                $string .= $category->name . '/';
            }
        }
        return $string . $this->name;
    }

    /**
     * @return array
     */
    public function getSelectChildArray()
    {
        $parent = $this->getParentCategory();

        $parentModel = Category::findOne($parent->id);
        $query = $parentModel->children(1)->all();

        $child = [];
        if ($query) {
            foreach ($query as $n => $category) {
                if ($category->id == $this->id) {
                    $child[$category->id] = '>>> ' . Html::encode($category->name);
                } else {
                    $child[$category->id] = Html::encode($category->name);
                }
            }
        }
        return $child;
    }

    /**
     * @return Category[]|array|bool
     */
    public function getCategoriesAll()
    {
        $model = new Category();
        $query = $model->find()
            ->orderBy(['lft' => SORT_ASC])
            ->all();
        return $query ? $query : null;
    }

    /**
     * @return Category[]|array|bool
     */
    public function getCategories()
    {
        $model = new Category();
        $query = $model->find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->andWhere('depth > 0')
            ->orderBy(['lft' => SORT_ASC])
            ->all();
        return $query;
    }

    /**
     * Get Root Category
     * @return array|Category|null
     */
    public function getRootCategory()
    {
        $model = new Category();
        $root = $model->find()
            ->where(['status' => self::STATUS_PUBLISH])
            ->andWhere(['depth' => 0])
            ->one();
        return $root;
    }

    /**
     * @return mixed
     */
    public function getParentCategory()
    {
        $parent = $this->parents(1)->one();
        return $parent;
    }

    /**
     * @param array $breadcrumbs
     * @return array
     */
    public function getBreadcrumbsCategory($breadcrumbs = [])
    {
        $parents = $this->parents()->all();
        foreach ($parents as $category) {
            if ($category->depth > 0) {
                if ($this->id !== $category->id) {
                    $breadcrumbs[] = [
                        'label' => $category->name,
                        'url' => Url::to(['default/category', 'id' => $category->id, 'slug' => $category->slug]),
                    ];
                }
            }
        }
        return $breadcrumbs;
    }

    /**
     * Render Tree
     * @param int $depth
     * @return array
     */
    public function getRenderTree($depth = 0)
    {
        $array = [];
        if ($query = self::getCategories()) {
            $i = 0;
            foreach ($query as $n => $category) {
                if ($category->depth == $depth) {
                    $array[] = $i ? Html::endTag('li') . PHP_EOL : '';
                } else if ($category->depth > $depth) {
                    $array[] = Html::beginTag('ul') . PHP_EOL;
                } else {
                    $array[] = Html::endTag('li') . PHP_EOL;
                    for ($i = $depth - $category->depth; $i; $i--) {
                        $array[] = Html::endTag('ul') . PHP_EOL;
                        $array[] = Html::endTag('li') . PHP_EOL;
                    }
                }
                $array[] = Html::beginTag('li') . PHP_EOL;
                $array[] = Html::encode($category->name) . PHP_EOL;
                $depth = $category->depth;
                $i++;
            }
            for ($i = $depth; $i; $i--) {
                $array[] = Html::endTag('li') . PHP_EOL;
                $array[] = Html::endTag('ul') . PHP_EOL;
            }
        }
        return $array;
    }

    /**
     * @param int $limit
     * @return ActiveDataProvider
     */
    public function getDataProviderCategories($limit = 20)
    {
        $query = $this->children($this->depth);
        $query->andWhere(['status' => self::STATUS_PUBLISH]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ],
        ]);
        return $dataProvider;
    }

    /**
     * @param int $limit
     * @return ActiveDataProvider
     */
    /*public function getDataProviderProducts($limit = 20)
    {
        $products = $this->getCatalogProducts()->where(['status' => CatalogProduct::STATUS_PUBLISH]);
        $dataProvider = new ActiveDataProvider([
            'query' => $products,
            'pagination' => [
                'pageSize' => $limit,
            ],
        ]);
        return $dataProvider;
    }*/

    /**
     * Вывод всех товаров из категории включая дочерние
     * отсортированные по категориям и позиции товара
     * @param int $limit
     * @return ActiveDataProvider
     */
    public function getTreeCategoriesAllProducts($limit = 20)
    {
        $categoriesChildren = $this->children()->andWhere(['status' => self::STATUS_PUBLISH])->all();
        $category_id = [$this->id];
        foreach ($categoriesChildren as $children) {
            $category_id[] = $children->id;
        }
        $products = Product::find()->where([
            'category_id' => $category_id,
            'status' => Product::STATUS_PUBLISH
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $products,
            'sort' => [
                'defaultOrder' => [
                    'category_id' => SORT_ASC,
                    'position' => SORT_ASC
                ]
            ],
            'pagination' => [
                'pageSize' => $limit,
            ],
        ]);
        return $dataProvider;
    }

    /**
     * Change status to children
     * @return bool
     */
    private function childStatus()
    {
        $models = Category::find()
            ->where('lft > ' . $this->lft . ' and rgt < ' . $this->rgt)
            ->all();
        if (is_array($models)) {
            foreach ($models as $model) {
                $model->status = $this->status;
                $model->save();
            }
            return true;
        }
        return false;
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!$this->isNewRecord) {
            $this->childStatus();
        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        parent::beforeDelete();
        // Проверяем наличие товаров
        if ($products = $this->catalogProducts) {
            Yii::$app->session->setFlash('error', Module::t('module', 'The category contains the goods. To remove a category, release the category from the goods.'));
            return false;
        }
        return true;
    }
}
