<?php

use yii\helpers\Html;
use yii\grid\GridView;
use modules\catalog\assets\BackendAsset;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

BackendAsset::register($this);

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/catalog/default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Orders');
?>
<div class="catalog-backend-order-index">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Orders')) ?></h3>

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
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-success',
                        'title' => Module::t('module', 'Create Order'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'top',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-orders',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterSelector' => 'select[name="per-page"]',
                'showFooter' => true,
                'layout' => "{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    // 'first_name',
                    // 'last_name',
                    // 'email:email',
                    // 'phone',
                    // 'address',
                    'created_at:datetime',
                    'updated_at:datetime',
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
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
