<?php

namespace modules\catalog\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use modules\catalog\models\query\CatalogOrderQuery;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "{{%catalog_order}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property integer $address
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property CatalogOrderProduct[] $catalogOrderProducts
 */
class CatalogOrder extends \yii\db\ActiveRecord
{
    /**
     * Статус заказа "Без статуса"
     * Данный статус получает заказ на стадии оформления
     */
    const STATUS_ORDER_DEFAULT = 0;

    /**
     * Статус заказа "Новый"
     * Обо всех заказах со статусом “Новый” администратор получает уведомления по почте,
     * что позволяет ему мгновенно связываться с покупателем. Для удобства учета новых заказов,
     * они автоматически попадают во вкладку “Новые” на панели управления заказами и отображаются
     * в виде списка с сортировкой по дате добавления;
     */
    const STATUS_ORDER_NEW = 1;

    /**
     * Статус заказа "Обработан"
     * Заказ принят и может быть оплачен. Статус введен, в основном, для удобства внутреннего ведения заказов,
     * уже не “Новые”, но еще не оплаченные или не отправленные в доставку;
     */
    const STATUS_ORDER_PROCESSED = 2;

    /**
     * Статус заказа "Оплачивается"
     * Статус может быть назначен администратором, после отправки клиенту счета для оплаты.
     */
    const STATUS_ORDER_PROCESS_PAYMENT = 3;

    /**
     * Статус заказа "Оплачен"
     * Статус присваивается заказу автоматически, если расчет произведен через платежную систему Деньги Online.
     * В случае, если товар был доставлен курьером и оплачен наличными, статус может использоваться как отчетный;
     */
    const STATUS_ORDER_PAID = 4;

    /**
     * Статус заказа "В доставку"
     * Администратор присваивает заказам этот статус при составлении листа доставки.
     * Лист передается курьеру вместе с товарами.
     */
    const STATUS_ORDER_IN_THE_DELIVERY = 5;

    /**
     * Статус заказа "Доставляется"
     * Статус присваивается заказам, переданным курьеру. Заказ может сохранять этот статус достаточно долго,
     * в зависимости от того как далеко находится клиент;
     */
    const STATUS_ORDER_DELIVERED = 6;

    /**
     * Статус заказа "Готов"
     * Статус присваивается заказу, если товар доставлен, оплачен, и его можно отправить в архив.
     * Заказы с этим статусом нужны вам только для внутреннего учета.
     */
    const STATUS_ORDER_READY = 7;

    /**
     * Статус заказа "Отказан"
     * Статус присваивается заказам, которые не могут быть удовлетворены (например, товара нет на складе).
     * Позже вы в любой момент можете изменить статус заказа (например, если товар появился на складе);
     */
    const STATUS_ORDER_REFUSED = 8;

    /**
     * Статус заказа "Отменён"
     * Администратор присваивает заказу такой статус, если клиент по каким-то причинам отказался от заказа;
     */
    const STATUS_ORDER_CANCELED = 9;

    /**
     * Статус заказа "Возврат"
     * Администратор присваивает заказу такой статус, если клиент по каким-то причинам вернул товар.
     */
    const STATUS_ORDER_RETURN = 10;

    /**
     * Сценарий для консольного приложения
     */
    const SCENARIO_ADMIN_CONSOLE = 'adminConsole';

    /**
     * Сценарий оформления заказа
     */
    const SCENARIO_USER_ORDERING = 'userOrdering';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_order}}';
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
            [['first_name', 'last_name', 'email', 'phone', 'address'], 'required', 'on' => [self::SCENARIO_USER_ORDERING]],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'email', 'phone', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => Module::t('module', 'First Name'),
            'last_name' => Module::t('module', 'Last Name'),
            'email' => Module::t('module', 'Email'),
            'phone' => Module::t('module', 'Phone'),
            'address' => Module::t('module', 'Address'),
            'status' => Module::t('module', 'Status'),
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
        ];
    }

    /**
     * @inheritdoc
     * @return CatalogOrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CatalogOrderQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogOrderProducts()
    {
        return $this->hasMany(CatalogOrderProduct::class, ['order_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_ORDER_DEFAULT => Module::t('module', 'Default'),
            self::STATUS_ORDER_NEW => Module::t('module', 'New'),
            self::STATUS_ORDER_PROCESSED => Module::t('module', 'Processed'),
            self::STATUS_ORDER_PROCESS_PAYMENT => Module::t('module', 'Process payment'),
            self::STATUS_ORDER_PAID => Module::t('module', 'Paid'),
            self::STATUS_ORDER_IN_THE_DELIVERY => Module::t('module', 'Order in the delivery'),
            self::STATUS_ORDER_DELIVERED => Module::t('module', 'Delivered'),
            self::STATUS_ORDER_READY => Module::t('module', 'Ready'),
            self::STATUS_ORDER_REFUSED => Module::t('module', 'Refused'),
            self::STATUS_ORDER_CANCELED => Module::t('module', 'Canceled'),
            self::STATUS_ORDER_RETURN => Module::t('module', 'Return'),
        ];
    }

    /**
     * @return array
     */
    public function getAddressesArray()
    {
        return [];
    }

    /**
     * Сумма продуктов в заказе
     * @return int
     */
    public function getProductsCount()
    {
        $products = $this->catalogOrderProducts;
        $count = 0;
        foreach ($products as $product) {
            $count += $product->count;
        }
        return $count;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getAmount()
    {
        $products = $this->catalogOrderProducts;
        $total = 0;
        /** @var  $product CatalogOrderProduct */
        foreach ($products as $product) {
            /** @var integer $price */
            $total += $product->price * $product->count;
        }
        return $total;
    }

    /**
     * Скидка в %
     * @param $amount int
     * @param int $percent
     * @return float|int
     */
    public function getDiscount($amount, $percent = 0)
    {
        $val = $percent / 100; // Узнаем, сколько рублей составляет скидка, для этого число процентов записываем в виде десятичной дроби
        $summ = $amount * $val; // Умножаем первоначальную цену на полученное число
        return $amount - $summ; // Узнаем стоимость товара после скидки
    }

    /**
     * Формат цены
     * @param int $value
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getCurrency($value = 0)
    {
        return Yii::$app->formatter->asCurrency($value, Module::$currencyUnit, [
            \NumberFormatter::MAX_FRACTION_DIGITS => Module::$maxFactionDigits,
        ]);
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function beforeDelete()
    {
        parent::beforeDelete();
        // Удаляем товары из заказа
        $products = $this->catalogOrderProducts;
        foreach ($products as $product) {
            $product->delete();
        }
        return true;
    }
}
