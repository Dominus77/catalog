<?php

namespace modules\catalog\traits;

use Yii;
use modules\catalog\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\catalog\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('catalog');
    }
}
