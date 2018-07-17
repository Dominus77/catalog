<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-backend-order-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-order'
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'First Name'),
    ]) ?>

    <?= $form->field($model, 'last_name')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Last Name'),
    ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Email'),
    ]) ?>

    <?= $form->field($model, 'phone')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Phone'),
    ]) ?>

    <?= $form->field($model, 'address')->textInput([
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Address'),
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [
        'class' => 'form-control',
    ]); ?>

    <?php ActiveForm::end(); ?>

</div>
