<?php

use modules\catalog\Module;

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
    <?= $this->render('_view', [
        'dataProvider' => $dataProvider,
        'model' => $model,
        'formProduct' => $formProduct,

    ]); ?>
    <?php if (!Yii::$app->cart->isEmpty()) : ?>
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-warning" href="#">Оформить заказ</a>
            </div>
        </div>
    <?php endif; ?>
</div>
