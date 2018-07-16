<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogOrderProduct */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/catalog/default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Orders Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Add Product in Order');
?>
<div class="catalog-backend-order-product-create">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'New Orders Product')) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="fa fa-plus"></span> ' . Module::t('module', 'Add'), [
                    'class' => 'btn btn-success',
                    'name' => 'submit-button',
                    'form' => 'form-order-product',
                ]) ?>
            </div>
        </div>
    </div>
</div>
