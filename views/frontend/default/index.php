<?php

use yii\helpers\Html;
use modules\catalog\widgets\tree_menu\TreeMenu;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogCategory */

$this->title = $model->rootCategory->name ? $model->rootCategory->name : Module::t('module', 'Catalog');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-frontend-default-index">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Module::t('module', 'Categories') ?>
                </div>
                <div class="panel-body">
                    <?= TreeMenu::widget([
                        'dataTree' => $model->getCategories(),
                        'message' => Module::t('module', 'No categories.'),
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= $model->rootCategory->description ?>
        </div>

    </div>
</div>
