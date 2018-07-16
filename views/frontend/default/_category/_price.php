<?php

/** @var $this \yii\web\View */

/** @var $model  modules\catalog\models\CatalogProduct */

use modules\catalog\helpers\ShopHelper;

?>
<span class="lead"><?= ShopHelper::Currency($model->retail) ?></span>
