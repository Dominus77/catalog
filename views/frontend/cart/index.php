<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $dataProvider modules\catalog\models\CatalogCategory */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

$this->title = Module::t('module', 'Cart');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Catalog'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(new \yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
    });
"));
?>
<div class="catalog-frontend-cart-index">
    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'emptyText' => $this->render('_empty'),
            'layout' => "{items}\n{pager}",
            'itemView' => function ($model, $key, $index, $widget) use ($formProduct) {
                return $this->render('_list', [
                    'model' => $model,
                    'formProduct' => $formProduct,
                ]);
            },
        ]); ?>
    </div>
    <?php if (!Yii::$app->cart->isEmpty()) : ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-warning" href="#">Оформить заказ</a>
            </div>
        </div>
    <?php endif; ?>
</div>
