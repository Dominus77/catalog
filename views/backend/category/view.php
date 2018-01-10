<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogCategory */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'View');

$this->registerJs("$('#status_link_" . $model->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
?>
<div class="catalog-backend-category-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->name) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'slug',
                    'description:ntext',
                    'created_at:datetime',
                    'updated_at:datetime',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => Html::a($model->statusLabelName, Url::to(['status', 'id' => $model->id]), [
                            'id' => 'status_link_' . $model->id,
                            'title' => Module::t('module', 'Click to change the status.'),
                            'data' => [
                                'toggle' => 'tooltip',
                            ],
                        ]),
                        'contentOptions' => [
                            'class' => 'link-decoration-none',
                        ],
                    ],
                    'meta_description',
                    'meta_keywords',
                ],
            ]) ?>
        </div>
        <div class="box-footer">
            <p>
                <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Module::t('module', 'Update'), ['update', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon glyphicon-random" aria-hidden="true"></span> ' . Module::t('module', 'Move'), ['move', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-copy" aria-hidden="true"></span> ' . Module::t('module', 'Clone'), ['clone', 'id' => $model->id], [
                    'class' => 'btn btn-primary'
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ' . Module::t('module', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Module::t('module', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
</div>