<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\catalog\Module;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogOrderProduct */
/* @var $formProduct modules\catalog\models\form\BuyProductForm */

?>

<div class="cart-item">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="<?= Url::to(['default/product', 'id' => $model->product->id, 'slug' => $model->product->slug]) ?>"><?= $model->product->name ?></a>
                <div class="pull-right">
                    <?= Html::a('&times;', ['delete-from-cart', 'id' => $model->product->id], [
                        'class' => 'close',
                        'title' => Module::t('module', 'Delete'),
                        'data' => [
                            'method' => 'post',
                            'toggle' => 'tooltip',
                            'confirm' => Module::t('module', 'Are you sure you want to delete the item from the shopping cart?'),
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="panel-body">

                <p><img class="img-thumbnail img-responsive" src="<?= $model->product->images[0] ?>"></p>

                <?php $form = ActiveForm::begin([
                    'action' => Url::to(['set-count', 'id' => $model->product->id]),
                    'layout' => 'horizontal',
                ]); ?>

                <?php
                $save = Html::submitButton('<span class="glyphicon glyphicon-floppy-save"></span>', [
                    'class' => 'btn btn-default btn-block',
                    'name' => 'submit-button',
                    'title' => Module::t('module', 'Save'),
                    'data' => [
                        'toggle' => 'tooltip',
                        'placement' => 'bottom',
                    ],
                ])
                ?>
                <?= $form->field($formProduct, 'count', [
                    'template' => '<div class="col-xs-12 col-md-8">{input}</div>',
                    'inputTemplate' => '<div class="input-group">{input}<span class="input-group-btn">' . $save . '</span></div>',
                ])->textInput([
                    'type' => 'number',
                    'min' => 1,
                    'max' => $model->product->availability,
                    'value' => $model->count,
                ])->label(false) ?>
                <?php ActiveForm::end(); ?>

                <div class="row">
                    <div class="col-xs-4 col-md-4">
                        <strong><?= Module::t('module', 'Retail') ?>:</strong>
                    </div>
                    <div class="col-xs-4 col-md-8">
                        <?= Yii::$app->formatter->asCurrency($model->price, Module::$currencyUnit, [
                            \NumberFormatter::MAX_FRACTION_DIGITS => Module::$maxFactionDigits,
                        ]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-4 col-md-4">
                        <strong><?= Module::t('module', 'Total') ?>:</strong>
                    </div>
                    <div class="col-xs-4 col-md-8">
                        <strong><?= Yii::$app->formatter->asCurrency($model->count * $model->price, Module::$currencyUnit, [
                                \NumberFormatter::MAX_FRACTION_DIGITS => Module::$maxFactionDigits,
                            ]); ?></strong>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
