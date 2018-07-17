<?php
namespace modules\catalog\commands;

use Yii;
use yii\base\Model;
use yii\console\Controller;
use yii\console\Exception;
use console\components\helpers\Console;
use modules\catalog\models\Order;
use modules\catalog\Module;

/**
 * Class OrderController
 * @package modules\catalog\commands
 */
class OrderController extends Controller
{
    public function actionIndex()
    {
        echo 'yii catalog/order/index' . PHP_EOL;
    }

    /**
     * @param $order_id
     * @return null|static
     * @throws Exception
     */
    private function findModel($order_id)
    {
        if (!$model = Order::findOne(['id' => $order_id])) {
            throw new Exception(
                Console::convertEncoding(
                    Module::t('module', 'Order "{:OrderId}" not found', [':OrderId' => $order_id])
                )
            );
        }
        return $model;
    }

    /**
     * @param Model $model
     * @param string $attribute
     */
    private function readValue($model, $attribute)
    {
        $model->$attribute = $this->prompt(Console::convertEncoding(Module::t('module', mb_convert_case($attribute, MB_CASE_TITLE, 'UTF-8') . ':')), [
            'validator' => function ($input, &$error) use ($model, $attribute) {
                $model->$attribute = $input;
                if ($model->validate([$attribute])) {
                    return true;
                } else {
                    $error = Console::convertEncoding(implode(',', $model->getErrors($attribute)));
                    return false;
                }
            },
        ]);
    }

    /**
     * @param bool $success
     */
    private function log($success)
    {
        if ($success) {
            $this->stdout(Console::convertEncoding(Module::t('module', 'Success!')), Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr(Console::convertEncoding(Module::t('module', 'Error!')), Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }
}