<?php

namespace modules\catalog\controllers\frontend;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * Class PaymentsController
 * @package modules\catalog\controllers\frontend
 */
class PaymentsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'order-check' => ['post'],
                    'payment-notification' => ['post'],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
