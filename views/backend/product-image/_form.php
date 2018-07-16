<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $files modules\catalog\models\UploadForm */
/* @var $model modules\catalog\models\CatalogProductImage */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="catalog-backend-product-image-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-product-image',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>
    <div class="row">
        <?php if ($model->scenario === $model::SCENARIO_UPDATE) : ?>
            <div class="col-md-6">
                <div class="thumbs">
                    <?= Html::img($model->getCellImage($model->image), [
                        'id' => 'image_' . $model->id,
                        'class' => 'img-thumbnail img-responsive',
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-6">
            <?php if ($model->scenario === $model::SCENARIO_CREATE) : ?>
                <?= $form->field($files, 'imageFiles[]')->fileInput([
                    'multiple' => ($model->scenario === $model::SCENARIO_CREATE) ? true : false,
                    'accept' => 'image/*',
                ]) ?>
            <?php endif; ?>

            <?= $form->field($model, 'product_id')->dropDownList($model->getProductsArray(), [
                'class' => 'form-control'
            ]); ?>

            <?php if ($model->scenario === $model::SCENARIO_UPDATE) : ?>
                <?= $form->field($model, 'position')->textInput([
                    'class' => 'form-control',
                    'placeholder' => Module::t('module', 'Position'),
                ]) ?>
            <?php endif; ?>

            <?= $form->field($model, 'status')->dropDownList($model->getStatusesArray(), [
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>