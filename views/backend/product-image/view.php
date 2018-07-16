<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogProductImage */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'View');

$this->registerJs("$('#status_link_" . $model->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
?>
<div class="catalog-backend-product-image-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'View') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <div class="row">
                <div class="col-md-6">
                    <?= Html::img($model->getCellImage(), [
                        'id' => 'image_' . $model->id,
                        'class' => 'img-thumbnail img-responsive',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'product_id',
                                'format' => 'raw',
                                'value' => $model->product->name,
                            ],
                            'position',
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
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="box-footer">
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
</div>