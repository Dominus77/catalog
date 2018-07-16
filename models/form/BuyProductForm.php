<?php

namespace modules\catalog\models\form;

use yii\base\Model;
use modules\catalog\Module;

/**
 * Class BuyProductForm
 * @package modules\catalog\models\form
 */
class BuyProductForm extends Model
{
    public $count;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['count', 'required'],
            ['count', 'integer', 'min' => 1],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'count' => Module::t('module', 'Count'),
        ];
    }
}