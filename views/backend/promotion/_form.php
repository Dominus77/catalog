<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datetimepicker\DateTimePicker;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogPromotion */
/* @var $form yii\widgets\ActiveForm */

$language = substr(\Yii::$app->language, 0, 2);
?>

<div class="catalog-backend-promotion-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-promotion',
    ]); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'discount')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'start_at')->widget(DateTimePicker::class, [
                'language' => $language,
                'size' => 'xs',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy HH:ii',
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'end_at')->widget(DateTimePicker::class, [
                'language' => $language,
                'size' => 'xs',
                'pickButtonIcon' => 'glyphicon glyphicon-time',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy HH:ii',
                    'todayBtn' => true
                ]
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
