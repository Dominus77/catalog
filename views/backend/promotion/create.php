<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model modules\catalog\models\CatalogPromotion */

$this->title = 'Create Catalog Promotion';
$this->params['breadcrumbs'][] = ['label' => 'Catalog Promotions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-promotion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
