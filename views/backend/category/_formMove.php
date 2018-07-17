<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Category */
/* @var $form yii\widgets\ActiveForm */

$script = new \yii\web\JsExpression("
    function loadChild(obj) {
        var url = '" . Url::to('lists?node_id=') . "' + obj.value + '&id=" . $model->id . "';
        $.post(url, function(data) {
            $('#select-category-child').html(data);
        });
    }
");
$this->registerJs($script, \yii\web\View::POS_END);
?>

<div class="catalog-backend-category-formMove">
    <?php $form = ActiveForm::begin([
        'id' => 'form-category-move',
    ]); ?>

    <?= $form->field($model, 'parent')->dropDownList($model->getSelectArray(), [
        'class' => 'form-control',
        'onchange' => 'loadChild(this)',
    ]); ?>

    <?= $form->field($model, 'child', [
        'inputOptions' => [
            'size' => 10,
            'encode' => false
        ]
    ])->listBox($model->getSelectChildArray(), [
        'id' => 'select-category-child',
        'class' => 'form-control',
    ]) ?>

    <?= $form->field($model, 'position')->radioList($model->getMovePositionsArray()); ?>

    <?php ActiveForm::end(); ?>
</div>
