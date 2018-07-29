<?php

namespace modules\catalog\components\exportable\contracts;

use yii\data\ActiveDataProvider;

/**
 * Interface ExportableServiceInterface
 * @package modules\catalog\components\exportable\contracts
 */
interface ExportableServiceInterface
{
    /**
     * Runs the force download of the file
     *
     * @param string $filename
     * @param string $mime
     * @param ActiveDataProvider $dataProvider
     */
    public function run($filename, $mime, ActiveDataProvider $dataProvider);
}
