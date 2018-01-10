<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $crop modules\catalog\models\CropImageForm */
/* @var $files modules\catalog\models\UploadForm */
/* @var $model modules\catalog\models\CatalogProductImage */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::img($model->getCellImage(), [
    'class' => 'img-thumbnail',
    'width' => 35,
    'height' => 35,
]), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Update');
?>
<div class="catalog-backend-product-image-update">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Update') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <?= $this->render('_form', [
                'model' => $model,
                'files' => $files,
                'crop' => $crop,
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="fa fa-floppy-o"></span> ' . Module::t('module', 'Save'), [
                    'class' => 'btn btn-primary',
                    'name' => 'submit-button',
                    'form' => 'form-product-image',
                ]) ?>
            </div>
        </div>
    </div>
</div>