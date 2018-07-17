<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use modules\catalog\assets\BackendAsset;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

BackendAsset::register($this);

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Catalog'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Categories');
?>

<div class="catalog-backend-category-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Categories')) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-block btn-success',
                        'title' => Module::t('module', 'Create Category'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'left',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?php Pjax::begin([
                'id' => 'pjax-container',
                'enablePushState' => false,
                'timeout' => 5000,
            ]); ?>
            <?= GridView::widget([
                'id' => 'grid-categories',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "{items}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'rowOptions' => function ($data) {
                    if ($data->isDraft()) {
                        return ['class' => 'warning'];
                    } else if ($data->isDeleted()) {
                        return ['class' => 'danger'];
                    }
                    return false;
                },
                'columns' => [
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'contentOptions' => [
                            'style' => 'width:50px',
                        ],
                    ],
                    [
                        'attribute' => 'name',
                        'filter' => Html::activeInput('text', $searchModel, 'name', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            $depth = $data->depth * 10;
                            /** @var  $data \modules\catalog\models\Category */
                            $name = $data->name . ' ' . $data->getProductsCount('default');
                            if ($data->depth == 0)
                                $name = "<i class='glyphicon glyphicon-home'></i> " . $name;
                            return Html::tag('span', $name, ['style' => 'padding-left:' . $depth . 'px;']);
                        },
                        'contentOptions' => [
                            'class' => '',
                        ],
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusesArray, [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::a($data->statusLabelName, ['set-status', 'id' => $data->id], [
                                'id' => $data->id,
                                'class' => 'link-status',
                                'title' => Module::t('module', 'Click to change the status'),
                                'data' => [
                                    'toggle' => 'tooltip',
                                    'pjax' => 0,
                                ],
                            ]);
                        },
                        'headerOptions' => [
                            'class' => 'text-center',
                        ],
                        'contentOptions' => [
                            'class' => 'col-md-1 title-column link-decoration-none',
                        ],
                    ],
                    [
                        'attribute' => 'id',
                        'filter' => false,
                        'contentOptions' => [
                            'style' => 'width:50px',
                            //'class' => 'col-md-1',
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'col-md-2 text-center',
                        ],
                        'template' => '{view} {update} {move} {clone} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                    'title' => Module::t('module', 'View'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Module::t('module', 'Update'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'clone' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, [
                                    'title' => Module::t('module', 'Clone'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'move' => function ($url, $model) {
                                if ($model->depth > 0) {
                                    return Html::a('<span class="glyphicon glyphicon glyphicon-random"></span>', $url, [
                                        'title' => Module::t('module', 'Move'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'pjax' => 0,
                                        ]
                                    ]);
                                }
                                return '<span class="glyphicon glyphicon glyphicon-random text-muted"></span>';
                            },
                            'delete' => function ($url, $model) {
                                if ($model->depth > 0) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => Module::t('module', 'Delete'),
                                        'data' => [
                                            'toggle' => 'tooltip',
                                            'method' => 'post',
                                            'confirm' => Module::t('module', 'Are you sure you want to delete this item?'),
                                            'pjax' => 0,
                                        ],
                                    ]);
                                }
                                return '<span class="glyphicon glyphicon-trash text-muted"></span>';
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
