<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $model modules\catalog\models\CatalogProduct */

?>
<h4><?= Module::t('module', 'Details') ?></h4>

<div class="row">
    <div class="col-md-6">
        <?php foreach ($model->catalogProductImages as $image) {
            echo Html::beginTag('div', ['class' => 'col-md-3']);
            echo Html::img($image->getCellImage(), [
                'class' => 'img-thumbnail img-responsive',
            ]);
            echo Html::endTag('div');
        } ?>
    </div>
    <div class="col-md-6">
        <?= $model->description ?>
        <hr>
    </div>
</div>
