<?php

use yii\helpers\Html;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var integer $category \modules\catalog\models\CatalogCategory */
/* @var integer $product \modules\catalog\models\CatalogProduct */
/* @var integer $image \modules\catalog\models\CatalogProductImage */
/* @var integer $promotions \modules\catalog\models\CatalogPromotion */

$this->title = Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-backend-default-index">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Module::t('module', 'Menu') ?></h3>

            <div class="box-tools pull-right"></div>
        </div>
        <div class="box-body">
            <ul>
                <li><?= Html::a(Module::t('module', 'Categories') . ' <span class="label label-default">' . $category . '</span>', ['category/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Products') . ' <span class="label label-default">' . $product . '</span>', ['product/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Images') . ' <span class="label label-default">' . $image . '</span>', ['product-image/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Promotions') . ' <span class="label label-default">' . $promotions . '</span>', ['promotion/index']) ?></li>
            </ul>
            <div class="box-footer"></div>
        </div>
    </div>
</div>