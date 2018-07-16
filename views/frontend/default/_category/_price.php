<?php

/** @var $this \yii\web\View */

/** @var $model  modules\catalog\models\CatalogProduct */

use modules\catalog\helpers\ShopHelper;

?>
<?php if ($discount = $model->catalogProductPromotion->promotion->discount) : ?>
    <span class="lead">
        <small class="old-retail"><?= ShopHelper::Currency($model->retail) ?></small>
    <br>
        <?= ShopHelper::Currency(ShopHelper::Discount($model->retail, $model->catalogProductPromotion->promotion->discount)) ?>
     </span>
<?php else: ?>
    <span class="lead">
        <?= ShopHelper::Currency($model->retail) ?>
    </span>
<?php endif; ?>
