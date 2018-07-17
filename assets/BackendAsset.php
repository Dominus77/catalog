<?php

namespace modules\catalog\assets;

use yii\web\AssetBundle;

/**
 * Class BackendAsset
 * @package modules\catalog\assets
 */
class BackendAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @var array
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->js = [
            'js/backend.js',
        ];
    }

    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true,
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
