<?php

use modules\catalog\Module;

/* @var $item \modules\catalog\models\OrderProduct */

?>
<div class="row">
    <div class="col-md-4">
        <img class="img-thumbnail img-responsive" src="<?= $item->product->images[0] ?>">
    </div>
    <div class="col-md-8">
        <?= Module::t('module', 'Product') ?>: <?= $item->product->name ?><br>
        <?= Module::t('module', 'Retail') ?>: <?= Module::$currencyUnit ?> <?= $item->product->retail ?><br>
        <?= Module::t('module', 'Count') ?>: <?= $item->count ?><br>
        <?= Module::t('module', 'Total') ?>: <?= Module::$currencyUnit ?> <?= Yii::$app->formatter->asDecimal($item->count * $item->product->retail, 2) ?><br>
    </div>
</div>