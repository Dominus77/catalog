<?php

namespace modules\catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use modules\catalog\Module;

/**
 * This is the model class for table "{{%catalog_order_product}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $order_id
 * @property integer $count
 * @property number $price
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Order $orders
 * @property Product $product
 */
class OrderProduct extends \yii\db\ActiveRecord
{
    const SCENARIO_ADMIN_ADD_PRODUCT = 'adminAddProduct';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_order_product}}';
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['order_id', 'count'], 'required', 'on' => self::SCENARIO_ADMIN_ADD_PRODUCT],
            [['product_id', 'order_id', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id'], 'on' => self::SCENARIO_ADMIN_ADD_PRODUCT],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_ADD_PRODUCT] = ['product_id', 'order_id', 'count', 'created_at', 'updated_at'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => Module::t('module', 'Product'),
            'order_id' => Module::t('module', 'Order'),
            'count' => Module::t('module', 'Count'),
            'price' => Module::t('module', 'Price'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return array
     */
    public function getOrdersArray()
    {
        $orders = Order::find()->all();
        return ArrayHelper::map($orders, 'id', 'id');
    }

    public function getProductsArray()
    {
        $products = Product::find()->all();
        return ArrayHelper::map($products, 'id', 'code');
    }

    /**
     * Изменена ли цена товара
     * @return bool
     */
    public function getIsChangePrice()
    {
        if ($this->price !== $this->product->retail) {
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
        if ($this->isNewRecord) {
            $this->price = $this->product->retail;
        }
        // Если товар обновляется
        if (!$this->isNewRecord) {
            // Если цена товара отличается от цены товара в корзине.
            if ($this->isChangePrice) {
                Yii::$app->session->setFlash('warning', Module::t('module', 'Price {:ProductName} has been changed! First, you must complete the current order.', [':ProductName' => $this->product->name]));
                return false;
            }
        }
        return parent::beforeSave($insert);
    }
}
