<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogPromotion */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Promotions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'View');

$this->registerJs("$('#status_link_" . $model->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
?>
<div class="catalog-backend-promotion-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($model->name) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <div class="row">
                <div class="col-md-12">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'name',
                            'description:ntext',
                            [
                                'attribute' => 'discount',
                                'value' => function ($model) {
                                    return $model->discount . '%';
                                }
                            ],
                            [
                                'attribute' => 'startAt',
                                'value' => $model->startAt,
                            ],
                            [
                                'attribute' => 'endAt',
                                'value' => $model->endAt,
                            ],
                            [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'value' => Html::a($model->statusLabelName, Url::to(['set-status', 'id' => $model->id]), [
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
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                    <p>
                        <?= Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ' . Module::t('module', 'Update'), ['update', 'id' => $model->id], [
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
            <div class="row">
                <div class="col-md-12">
                    <h3 class="box-title"><?= Module::t('module', 'Products') ?></h3>
                    <?= GridView::widget([
                        'id' => 'grid-products',
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table table-bordered table-hover',
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'code',
                            [
                                'attribute' => 'name',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a($data->name, ['product/view', 'id' => $data->id]);
                                }
                            ],
                            [
                                'attribute' => 'availability',
                                'format' => 'decimal',
                                'contentOptions' => [
                                    'class' => 'col-md-1 text-right',
                                ],
                            ],
                            [
                                'attribute' => 'category_id',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return $data->category->stringTreePath;
                                },
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}',
                                'buttons' => [
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['promotion/delete-product', 'id' => $model->id], [
                                            'title' => Module::t('module', 'Delete'),
                                            'data' => [
                                                'toggle' => 'tooltip',
                                                'method' => 'post',
                                                'pjax' => 0,
                                            ],
                                        ]);
                                    },
                                ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
