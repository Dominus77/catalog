<?php

namespace modules\catalog\widgets\tree_menu;

use yii\web\AssetBundle;

/**
 * Class TreeMenuAsset
 * @package modules\catalog\widgets\tree_menu
 */
class TreeMenuAsset extends AssetBundle
{
    public $sourcePath;
    public $css;
    public $js;

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->css = ['style.css'];
        $this->js = ['script.js'];
    }

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}