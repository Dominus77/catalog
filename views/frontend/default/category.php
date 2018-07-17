<?php

use yii\helpers\Url;
use yii\widgets\ListView;
use modules\catalog\widgets\tree_menu\TreeMenu;
use modules\catalog\assets\ProductAsset;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Category */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->rootCategory->name ? $model->rootCategory->name : Module::t('module', 'Catalog'), 'url' => ['index']];
$this->params['breadcrumbs'] = $model->getBreadcrumbsCategory($this->params['breadcrumbs']);
$this->params['breadcrumbs'][] = $this->title;

ProductAsset::register($this);
$this->registerJs(new \yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
    });
"));
?>
<div class="catalog-frontend-default-category">
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
                        'active' => $model->id,
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <a href="<?= Url::to(['cart/clean']) ?>" data-method="post">Сбросить ключ сессии</a>

            <div class="well well-sm">
                <strong><?= $this->title ?></strong>

                <div class="btn-group pull-right">
                    <a href="#" id="list" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-th-list"></span>
                        <?= Module::t('module', 'List') ?>
                    </a>
                    <a href="#" id="grid" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-th"></span>
                        <?= Module::t('module', 'Grid') ?>
                    </a>
                </div>
                <div class="clearfix"></div>

            </div>
            <?= ListView::widget([
                'dataProvider' => $model->getTreeCategoriesAllProducts(20),
                'layout' => "<div id='products' class='row list-group'>{items}</div>{pager}",
                'itemView' => function ($model, $key, $index, $widget) use ($formProduct) {
                    return $this->render('_category/list', [
                        'model' => $model,
                        'formProduct' => $formProduct,
                    ]);
                },
            ]); ?>
        </div>
    </div>
</div>
