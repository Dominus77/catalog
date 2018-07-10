<?php

/**
 * @var $this yii\web\View
 * @var $counter integer
 */

use yii\helpers\Html;
use yii\bootstrap\Modal;

$script = "
    $('#cart_image_wrapper').click(function(e) {
        e.preventDefault();
        $('#cart-modal').modal('show'); 
    });    
";
$this->registerJs($script);

?>
<div id="cart_wrapper">
    <?= $this->render('_cart') ?>
    <?php if ($counter) : ?>
        <div id="cart_counter" style="display: block;"><?= $counter ?></div>
    <?php endif; ?>
</div>

<?php Modal::begin([
    'header' => '<h3>Ваш заказ</h3>',
    'id' => 'cart-modal',
]);

echo $this->render('_empty');

Modal::end(); ?>
