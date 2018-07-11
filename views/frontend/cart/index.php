<?php

use yii\widgets\ListView;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $dataProvider modules\catalog\models\CatalogCategory */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */
/* @var $order modules\catalog\models\CatalogOrder */

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
        <div class="col-md-8">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'emptyText' => $this->render('_empty'),
                'layout' => "{items}\n{pager}",
                'itemView' => function ($model) use ($formProduct) {
                    return $this->render('_list', [
                        'model' => $model,
                        'formProduct' => $formProduct,
                    ]);
                },
            ]); ?>
        </div>
        <?php if (!Yii::$app->cart->isEmpty()) : ?>
            <div class="col-md-4">
                <h3>Информация о заказе</h3>
                <ul>
                    <li>Товаров: <?= $order->getProductsCount() ?></li>
                    <li>Сумма: <?= $order->getAmount() ?></li>
                    <li>Скидка: -10%</li>
                    <li>Доставка: 400р</li>
                    <li>И того: <?= $order->getAmount() ?></li>
                </ul>
                <a class="btn btn-sm btn-success" href="#">Оформить заказ</a>
            </div>
        <?php endif; ?>
    </div>
</div>
