<?php

use yii\helpers\Html;
use yii\grid\GridView;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\catalog\models\search\OrderProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['/catalog/default/index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Orders Product');
?>
<div class="catalog-backend-order-product-index">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode(Module::t('module', 'Orders Product')) ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <div class="pull-left">
            </div>
            <div class="pull-right">
                <p>
                    <?= Html::a('<span class="fa fa-plus"></span> ', ['create'], [
                        'class' => 'btn btn-success',
                        'title' => Module::t('module', 'Add Product in Order'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'top',
                            'pjax' => 0,
                        ],
                    ]) ?>
                </p>
            </div>
            <?= GridView::widget([
                'id' => 'grid-orders-product',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'showFooter' => true,
                'layout' => "{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover',
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    //'id',
                    'product_id',
                    'order_id',
                    'count',
                    'price',
                    'created_at:datetime',
                    'updated_at:datetime',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
        <div class="box-footer">
        </div>
    </div>
</div>