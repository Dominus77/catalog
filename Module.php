<?php

namespace modules\catalog;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\catalog
 */
class Module extends \yii\base\Module
{
    /**
     * Денежная еденица
     * &#8381; - Рубль
     * &#36; - Доллар США
     * &euro; - Евро
     * &pound; - Фунт (символ фунта стерлингов)
     * &yen; - Йена (знак Японской йены)
     * &#65509; - Китайский юань
     * &#8372; - Гривна
     * &cent; - Цент
     * &curren; - Знак валюты
     * @var string
     */
    public static $currencyUnit = 'RUB'; //'&#8381;';

    /**
     * Разрядность после точки в цене
     * @var int
     */
    public static $maxFactionDigits = 2;

    /**
     * @var string
     */
    public static $uploadDir = 'uploads/catalog';

    /**
     * Расширение файлов изображений
     * @var string
     */
    public static $imageExt = 'png, jpg';

    /**
     * Расширение файла импорта
     * xls, xlsx - Excel
     * @var string
     */
    public static $importExt = 'xls, xlsx';

    /**
     * @var int
     */
    public static $importMaxFiles = 1;

    /**
     * @var array
     */
    public static $imageSize = [500, 370]; // [250, 300] - [width, height]

    /**
     * @var array
     */
    public static $thumbSize = [100, 150];

    /**
     * @var int
     */
    public static $imageQuality = 100;

    /**
     * @var int
     */
    public static $maxFiles = 5;

    /**
     * Время по истечении которого заказ можно считать просроченным
     * 3 days (60 * 60 * 24 * 3 = 259200 sec)
     * @var int
     */
    public $orderConfirmTokenExpire;

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\catalog\controllers\frontend';

    /**
     * @var boolean Если модуль используется для админ-панели.
     */
    public $isBackend;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->orderConfirmTokenExpire = 60 * 60 * 24 * 3; // 3 days
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\catalog\commands';
        }
        // Это здесь для того, чтобы переключаться между frontend и backend
        if ($this->isBackend === true) {
            $this->controllerNamespace = 'modules\catalog\controllers\backend';
            $this->setViewPath('@modules/catalog/views/backend');
        } else {
            $this->setViewPath('@modules/catalog/views/frontend');
        }
    }

    /**
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/catalog/' . $category, $message, $params, $language);
    }
}
