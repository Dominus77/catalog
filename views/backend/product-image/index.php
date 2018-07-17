<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use modules\catalog\assets\BackendAsset;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\ProductImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

BackendAsset::register($this);

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Catalog'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Images');
?>
<div class="catalog-backend-product-image-index">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Images')) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right">
                <p>
                    <?php
                    $get = Yii::$app->request->get();
                    if (isset($get['CatalogProductImageSearch']['product_id']) && !empty($get['CatalogProductImageSearch']['product_id'])) {
                        $product_id = $get['CatalogProductImageSearch']['product_id'];
                        $url = Url::to(['create', 'id' => $product_id]);
                    } else {
                        $url = Url::to(['create']);
                    } ?>

                    <?= Html::a('<span class="fa fa-plus"></span> ', $url, [
                        'class' => 'btn btn-success',
                        'title' => Module::t('module', 'Add Image'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'left',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-product-image',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
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
                        'attribute' => 'image',
                        'filter' => false,
                        'format' => 'raw',
                        'value' => function ($data) {
                            /** @var $data \modules\catalog\models\ProductImage */
                            return Html::img($data->getCellImage($data->image), [
                                'class' => 'img-thumbnail img-responsive',
                                'width' => Module::$thumbSize[0],
                                'height' => Module::$thumbSize[1],
                            ]);
                        },
                        'headerOptions' => [
                            'class' => 'text-center',
                        ],
                        'contentOptions' => [
                            'class' => 'text-center',
                        ],
                    ],
                    [
                        'attribute' => 'product_id',
                        'filter' => Html::activeDropDownList($searchModel, 'product_id', $searchModel->productsArray, [
                            'class' => 'form-control',
                            'prompt' => Module::t('module', '- all -'),
                            'data' => [
                                'pjax' => true,
                            ],
                        ]),
                        'format' => 'raw',
                        'value' => function ($data) {
                            return $data->product->name;
                        },
                        'headerOptions' => [
                            'style' => 'width:60%',
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
                            'class' => 'title-column link-decoration-none',
                            'style' => 'width:150px',
                        ],
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
        <div class="box-footer"></div>
    </div>
</div>
