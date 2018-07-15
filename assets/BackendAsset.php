<?php

namespace modules\catalog\assets;

use yii\web\AssetBundle;

/**
 * Class BackendAsset
 * @package modules\catalog\assets
 */
class BackendAsset extends AssetBundle
{
    public $sourcePath;

    public $css;

    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->css = [
            'css/backend.css',
        ];
    }

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
