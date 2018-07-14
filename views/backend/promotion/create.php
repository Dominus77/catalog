<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogPromotion */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Promotions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'New Promotion');
?>
<div class="catalog-backend-promotion-create">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'New Promotion')) ?></h3>

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
                <?= Html::submitButton('<span class="fa fa-plus"></span> ' . Module::t('module', 'Create'), [
                    'class' => 'btn btn-success',
                    'name' => 'submit-button',
                    'form' => 'form-promotion',
                ]) ?>
            </div>
        </div>
    </div>
</div>
