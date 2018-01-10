<?php

use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Import */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="catalog-backend-product-import-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-product-import',
        'options' => [
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>

    <?= $form->field($model, 'file')->fileInput([
        'multiple' => false,
        'accept' => 'application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel',
    ])->hint(Module::t('module', 'File Microsoft Excel'), ['class' => 'text-muted']) ?>

    <h4><?= Module::t('module', 'Import Options') ?></h4>

    <?= $form->field($model, 'importOptionsUpdate')->checkbox(['class' => 'iCheck']); ?>
    <?= $form->field($model, 'importOptionsCreate')->checkbox(['class' => 'iCheck']); ?>
    <?= $form->field($model, 'importOptionsDelete')->checkbox(['class' => 'iCheck']); ?>

    <?php ActiveForm::end(); ?>
</div>