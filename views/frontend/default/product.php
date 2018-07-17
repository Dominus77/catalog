<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modules\catalog\widgets\tree_menu\TreeMenu;
use yii\widgets\ActiveForm;
use modules\catalog\helpers\ShopHelper;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\Product */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $model->category->rootCategory->name ? $model->category->rootCategory->name : Module::t('module', 'Catalog'), 'url' => ['default/index']];
$this->params['breadcrumbs'] = $model->category->getBreadcrumbsCategory($this->params['breadcrumbs']);
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['category', 'id' => $model->category->id, 'slug' => $model->category->slug]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(new \yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();
    });
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
                <div class="row">
                    <div class="col-md-12">
                        <?= $model->description ?>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 pull-left">
                        <p class="lead"><?= ShopHelper::Currency($model->retail) ?> </p>
                    </div>
                    <div class="col-md-3 pull-right">
                        <?php $form = ActiveForm::begin([
                            'action' => Url::to(['cart/add-in-cart', 'id' => $model->id]),
                        ]); ?>

                        <?= $form->field($formProduct, 'count', [
                            'template' => '{input}',
                        ])->textInput([
                            'type' => 'number',
                            'class' => 'form-control',
                            'min' => 0,
                            'max' => $model->availability,
                            'value' => 0,
                        ]) ?>

                        <?= Html::submitButton('<span class="glyphicon glyphicon-shopping-cart"></span> ' . Module::t('module', 'Buy'), [
                            'class' => 'btn btn-success pull-right',
                            'name' => 'submit-button',
                            'title' => Module::t('module', 'Add to cart'),
                            'data' => [
                                'toggle' => 'tooltip',
                                'placement' => 'bottom',
                            ],
                        ]) ?>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
