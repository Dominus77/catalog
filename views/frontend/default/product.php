<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use modules\catalog\widgets\tree_menu\TreeMenu;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogProduct */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->rootCategory->name ? $model->category->rootCategory->name : Module::t('module', 'Catalog'), 'url' => ['default/index']];
$this->params['breadcrumbs'] = $model->category->getBreadcrumbsCategory($this->params['breadcrumbs']);
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['category', 'id' => $model->category->id, 'slug' => $model->category->slug]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(new \yii\web\JsExpression("
    $('nav.thumb').on('click', 'a', function () {
       $(this).addClass('current').siblings().removeClass('current')
       $('.photo img').attr('src', $(this).prop('href'))
       return false;
    });
"));
?>
<div class="catalog-frontend-default-product">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Module::t('module', 'Categories') ?>
                </div>
                <div class="panel-body">
                    <?= TreeMenu::widget([
                        'dataTree' => $model->category->getCategories(),
                        'message' => Module::t('module', 'No categories.'),
                        'active' => $model->category_id,
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="col-md-12">
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="col-md-6">
                <figure class="photo">
                    <img class="img-thumbnail img-responsive" src="<?= $model->images[0] ?>">
                </figure>
                <div class="row">
                    <?php if ($model->images) {
                        foreach ($model->images as $image) {
                            echo Html::beginTag('nav', ['class' => 'thumb col-xs-6 col-sm-4 col-md-3']) . PHP_EOL;
                            echo Html::a(Html::img($image, ['class' => 'img-thumbnail img-responsive']), [$image], ['class' => 'current']) . PHP_EOL;
                            echo Html::endTag('nav') . PHP_EOL;
                        }
                    } ?>
                </div>
            </div>
            <div class="col-md-6">
                <?= $model->description ?>
            </div>
        </div>

    </div>
</div>
