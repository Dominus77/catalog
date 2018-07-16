<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogOrder */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'View');
?>
<div class="catalog-backend-order-view">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Order') . ' ' . $model->id) ?></h3>

            <div class="box-tools pull-right"><?= Module::t('module', 'Total') ?>
                : <?= Module::$currencyUnit ?> <?= $model->amount ?></div>
        </div>
        <div class="box-body">
            <div class="pull-left"></div>
            <div class="pull-right"></div>
            <div class="row">
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'first_name',
                            'last_name',
                            'email:email',
                            'phone',
                            'address',
                            'status',
                            'created_at:datetime',
                            'updated_at:datetime',
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?php
                    $items = [];
                    foreach ($model->catalogOrderProducts as $item) {
                        $items[] = [
                            'label' => $item->product->code . '<span class="pull-right"><small>' . Yii::$app->formatter->asDatetime($item->created_at) . '</small></span>',
                            'content' => $this->render('product_list', ['item' => $item]),
                        ];
                    }
                    if ($items) {
                        echo Collapse::widget([
                            'encodeLabels' => false,
                            'items' => $items,
                        ]);
                    }
                    ?>
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
