<?php

/**
 * @var $this yii\web\View
 * @var $count mixed
 */

use yii\helpers\Html;

?>
<div id="cart_wrapper">
    <?= Html::a($this->render('_cart'), ['/shop/cart/index']) ?>
    <?php if ($count) : ?>
        <div id="cart_counter" style="display: block;"><?= $count ?></div>
    <?php endif; ?>
</div>
