<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogCategory */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('module', 'Move');
?>
<div class="blog-backend-category-move">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->name); ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
        <?= $this->render('_formMove', [
            'model' => $model,
        ]) ?>
        </div>
        <div class="box-footer">
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon glyphicon-random"></span> ' . Module::t('module', 'Move'), [
                    'class' => 'btn btn-primary',
                    'name' => 'submit-button',
                    'form' => 'form-category-move',
                ]) ?>
            </div>
        </div>
    </div>
</div>
