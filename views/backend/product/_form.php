<?php

use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogProduct */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="catalog-backend-product-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-product',
    ]); ?>

    <?= $form->field($model, 'category_id')->dropDownList($model->getCategoriesTreeArray(), [
        'class' => 'form-control'
    ]); ?>

    <?= $form->field($model, 'code')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Code'),
    ]) ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Name'),
    ]) ?>

    <?= $form->field($model, 'slug')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Alias'),
    ]) ?>

    <?= $form->field($model, 'availability')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Availability'),
    ]) ?>

    <?= $form->field($model, 'retail')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Retail'),
    ]) ?>

    <?= $form->field($model, 'description')->textarea([
        'rows' => 6,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Description'),
    ]) ?>

    <?= $form->field($model, 'position')->textInput([
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Position'),
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [
        'class' => 'form-control',
    ]); ?>

    <?= $form->field($model, 'meta_description')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Meta-description'),
    ]) ?>

    <?= $form->field($model, 'meta_keywords')->textInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Meta-keywords'),
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>
