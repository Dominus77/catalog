<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use modules\catalog\Module;

/* @var $model modules\catalog\models\CatalogProduct */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

?>
<div class="item  col-xs-4 col-lg-4">
    <div class="thumbnail">
        <img class="group list-group-image" src="<?= $model->images[0] ?>" alt="" width="400" height="250"/>

        <div class="caption">
            <h4 class="group inner list-group-item-heading">
                <a href="<?= Url::to(['product', 'id' => $model->id, 'slug' => $model->slug]) ?>"><?= $model->name ?></a>
            </h4>

            <p class="group inner list-group-item-text size">
                <?= HtmlPurifier::process($model->description) ?></p>

            <div class="row">
                <div class="col-xs-12 col-md-8">
                    <p class="lead"><?= $model->retail ?> <?= Module::$currencyUnit; ?></p>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['cart/add-in-cart', 'id' => $model->id]),
                ]); ?>
                <div class="col-xs-12 col-md-4">
                    <?= $form->field($formProduct, 'count', [
                        'template' => '{input}',
                    ])->textInput([
                        'type' => 'number',
                        'class' => 'form-control',
                        'min' => 0,
                        'max' => $model->availability,
                        'value' => 0,
                    ]) ?>
                </div>
                <div class="col-xs-12 col-md-12">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-shopping-cart"></span> ' . Module::t('module', 'Buy'), [
                        'class' => 'btn btn-success pull-right',
                        'name' => 'submit-button',
                        'title' => Module::t('module', 'Add to cart'),
                        'data' => [
                            'toggle' => 'tooltip',
                            'placement' => 'bottom',
                        ],
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>