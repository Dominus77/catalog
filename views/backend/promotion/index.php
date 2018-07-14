<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\CatalogPromotionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/catalog/default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Promotions');

$language = substr(\Yii::$app->language, 0, 2);
?>
<div class="catalog-backend-promotion-index">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Promotions')) ?></h3>

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
                        'title' => Module::t('module', 'Create Promotion'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'top',
                            'pjax' => 0,
                        ],
                    ]) ?>
                    <?= Html::a(Module::t('module', 'Add Products'), ['create'], [
                        'class' => 'btn btn-primary',
                        'title' => Module::t('module', 'Add products in promotion'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'top',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-promotions',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'filterSelector' => 'select[name="per-page"]',
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
                    ['class' => 'yii\grid\SerialColumn'],
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
                        'attribute' => 'discount',
                        'filter' => Html::activeInput('text', $searchModel, 'discount', [
                            'class' => 'form-control',
                            'placeholder' => Module::t('module', '- number -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'value' => function ($data) {
                            return $data->discount . '%';
                        }
                    ],
                    [
                        'attribute' => 'start_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from_start',
                            'language' => $language,
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ],
                            'options' => [
                                'placeholder' => Module::t('module', '- select -'),
                                'data' => [
                                    'pjax' => true,
                                ],
                            ]
                        ]),
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDatetime($data->start_at, 'php:d-M-Y H:i');
                        }
                    ],
                    [
                        'attribute' => 'end_at',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from_end',
                            'language' => $language,
                            'template' => '{addon}{input}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd-mm-yyyy'
                            ],
                            'options' => [
                                'placeholder' => Module::t('module', '- select -'),
                                'data' => [
                                    'pjax' => true,
                                ],
                            ]
                        ]),
                        'value' => function ($data) {
                            return Yii::$app->formatter->asDatetime($data->end_at, 'php:d-M-Y H:i');
                        }
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
                            //$this->registerJs("$('#status_link_" . $data->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
                            return Html::a($data->statusLabelName, Url::to(['set-status', 'id' => $data->id]), [
                                'id' => 'status_link_' . $data->id,
                                'title' => Module::t('module', 'Click to change the status.'),
                                'data' => [
                                    'toggle' => 'tooltip',
                                    'method' => 'post',
                                    'pjax' => 0,
                                ],
                            ]);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>
