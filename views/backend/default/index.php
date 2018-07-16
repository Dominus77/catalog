<?php

use yii\helpers\Html;
use modules\catalog\Module;

/** @var $this yii\web\View */
/** @var array $counts */

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
                <li><?= Html::a(Module::t('module', 'Categories') . ' <span class="label label-default">' . $counts['category'] . '</span>', ['category/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Products') . ' <span class="label label-default">' . $counts['product'] . '</span>', ['product/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Images') . ' <span class="label label-default">' . $counts['image'] . '</span>', ['product-image/index']) ?></li>
                <li><?= Html::a(Module::t('module', 'Orders') . ' <span class="label label-default">' . $counts['order'] . '</span>', ['orders/index']) ?></li>
            </ul>
            <div class="box-footer"></div>
        </div>
    </div>
</div>
