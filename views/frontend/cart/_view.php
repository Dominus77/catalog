<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider modules\catalog\models\CatalogCategory */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

?>
<div class="row">
    <div class="col-md-8">
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
        <div class="col-md-4">
            <h3>Информация о заказе</h3>
        </div>
    <?php endif; ?>
</div>

