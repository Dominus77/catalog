<?php

namespace modules\catalog\widgets\shop;

use yii\web\AssetBundle;

/**
 * Class CartAsset
 * @package modules\catalog\widgets\shop
 */
class CartAsset extends AssetBundle
{
    public $sourcePath;
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->css = ['css/style.css'];
        $this->js = ['js/script.js'];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => false
    ];
}