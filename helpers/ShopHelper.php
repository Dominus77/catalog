<?php

namespace modules\catalog\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use modules\catalog\Module;

/**
 * Class ShopHelper
 * @package modules\catalog\helpers
 */
class ShopHelper
{
    /**
     * Расчет суммы со скидкой
     * @param float|int $amount
     * @param int $percent %
     * @return float|int
     */
    public static function Discount($amount = 0, $percent = 0)
    {
        $val = $percent / 100;      // Узнаем, сколько рублей составляет скидка, для этого число процентов записываем в виде десятичной дроби
        $result = $amount * $val;   // Умножаем первоначальную цену на полученное число
        return $amount - $result;   // Узнаем стоимость товара после скидки
    }

    /**
     * Формат цены
     * @param int $value
     * @param string $currencyUnit
     * @param array $params
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public static function Currency($value = 0, $currencyUnit = 'RUB', $params = [])
    {
        $params = ArrayHelper::merge([
            \NumberFormatter::MAX_FRACTION_DIGITS => 2,
        ], $params);
        return Yii::$app->formatter->asCurrency($value, $currencyUnit, $params);
    }
}
