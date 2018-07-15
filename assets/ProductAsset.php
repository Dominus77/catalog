<?php

namespace modules\catalog\assets;

use yii\web\AssetBundle;

/**
 * Class ProductAsset
 * @package modules\catalog\assets
 */
class ProductAsset extends AssetBundle
{
    public $sourcePath;

    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->css = [
            'css/product.css',
        ];
        $this->js = [
            'js/product.js',
        ];
    }

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
