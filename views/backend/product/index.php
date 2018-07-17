<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dimmitri\grid\ExpandRowColumn;
use yii\grid\GridView;
use yii\bootstrap\ButtonDropdown;
use modules\catalog\assets\BackendAsset;
use modules\catalog\helpers\ShopHelper;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

BackendAsset::register($this);

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/catalog/default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Products');
?>
<div class="catalog-backend-product-index">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Products')) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left">
                <?= common\widgets\PageSize::widget([
                    'label' => '',
                    'defaultPageSize' => 25,
                    'sizes' => [10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]); ?>
            </div>
            <div class="pull-right">
                <p>
                    <?= ButtonDropdown::widget([
                        'label' => '<span class="fa fa-file-excel-o"></span> ' . Module::t('module', 'Excel'),
                        'encodeLabel' => false,
                        'dropdown' => [
                            'encodeLabels' => false,
                            'items' => [
                                [
                                    'label' => '<span class="glyphicon glyphicon-export"></span> ' . Module::t('module', 'Export'),
                                    'url' => ['export', 'params' => Yii::$app->request->queryParams],
                                ],
                                [
                                    'label' => '<span class="glyphicon glyphicon-import"></span> ' . Module::t('module', 'Import'),
                                    'url' => ['import', 'params' => Yii::$app->request->queryParams],
                                ],
                            ],
                        ],
                        'options' => [
                            'class' => 'btn btn-default',
                        ],
                    ]); ?>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-success',
                        'title' => Module::t('module', 'Create Product'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'top',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-products',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterSelector' => 'select[name="per-page"]',
                'showFooter' => true,
                'layout' => "{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'rowOptions' => function ($data) {
                    if ($data->status == $data::STATUS_DRAFT) {
                        return ['class' => 'warning'];
                    }
                    return false;
                },
                'columns' => [
                    [
                        'attribute' => 'position',
                        'label' => '#',
                        'filter' => false,
                    ],
                    [
                        'class' => ExpandRowColumn::class,
                        'attribute' => 'code',
                        'filter' => Html::activeInput('text', $searchModel, 'code', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'ajaxErrorMessage' => 'Oops',
                        'ajaxMethod' => 'GET',
                        'url' => Url::to(['detail']),
                        'submitData' => function ($model, $key, $index) {
                            return ['id' => $model->id];
                        },
                        'enableCache' => false,
                        'contentOptions' => [
                            'class' => 'col-md-1',
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
                    ],
                    [
                        'attribute' => 'availability',
                        'filter' => Html::activeInput('text', $searchModel, 'availability', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'decimal',
                        'contentOptions' => [
                            'class' => 'col-md-1 text-right',
                        ],
                    ],
                    [
                        'attribute' => 'retail',
                        'filter' => Html::activeInput('text', $searchModel, 'retail', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- text -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'value' => function ($data) {
                            return ShopHelper::Currency($data->retail);
                        },
                        'contentOptions' => [
                            'class' => 'col-lg-1 text-right',
                        ],
                        'footer' => ShopHelper::Currency($searchModel::getTotal($dataProvider->models, 'retail', 'availability')),
                        'footerOptions' => [
                            'class' => 'col-md-1 text-right text-bold',
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
                        'attribute' => 'category_id',
                        'filter' => Html::activeDropDownList($searchModel, 'category_id', $searchModel->getCategoriesTreeArray(), [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->category->stringTreePath;
                        },
                        'contentOptions' => [
                            //'class' => 'col-md-2 text-center',
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'class' => 'text-center',
                            'style' => 'width:90px',
                        ],
                        'template' => '{view} {update} {image} {delete}',
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
                            'image' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-picture"></span>', $url, [
                                    'title' => Module::t('module', 'Image'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'pjax' => 0,
                                    ]
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Module::t('module', 'Delete'),
                                    'data' => [
                                        'toggle' => 'tooltip',
                                        'method' => 'post',
                                        'confirm' => Module::t('module', 'Are you sure you want to delete this item?'),
                                        'pjax' => 0,
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
