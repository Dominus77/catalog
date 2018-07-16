<?php

use yii\bootstrap\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-backend-category-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-category'
    ]); ?>

    <?php if ($model->scenario === $model::SCENARIO_CREATE) : ?>
        <?= $form->field($model, 'parent')->dropDownList($model->getSelectArray(), [
            'class' => 'form-control'
        ]); ?>
    <?php endif; ?>

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


    <?= $form->field($model, 'description')->textarea([
        'rows' => 6,
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Description'),
    ]) ?>


    <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [
        'class' => 'form-control'
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
