<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogOrderProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-backend-order-product-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-order-product',
    ]); ?>

    <?= $form->field($model, 'order_id')->dropDownList($model->getOrdersArray(), [
        'class' => 'form-control',
        'prompt' => Module::t('module', '- Select order -'),
    ]); ?>

    <?= $form->field($model, 'product_id')->dropDownList($model->getProductsArray(), [
        'class' => 'form-control',
        'prompt' => Module::t('module', '- Select product -'),
    ]); ?>

    <?= $form->field($model, 'count')->textInput([
        'class' => 'form-control',
        'placeholder' => Module::t('module', 'Count'),
    ]) ?>

    <?php ActiveForm::end(); ?>
</div>
