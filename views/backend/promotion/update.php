<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogPromotion */

$this->title = 'Update Catalog Promotion: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Catalog Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="catalog-promotion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
