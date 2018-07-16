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
