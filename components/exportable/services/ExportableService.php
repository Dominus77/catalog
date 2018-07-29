<?php

namespace modules\catalog\components\exportable\services;

use modules\catalog\components\exportable\contracts\ExportableServiceInterface;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

/**
 * Class ExportableService
 * @package modules\catalog\components\exportable\services
 */
class ExportableService implements ExportableServiceInterface
{
    /**
     * @inheritdoc
     */
    /**
     * @param string $filename
     * @param string $mime
     * @param \yii\data\ActiveDataProvider $dataProvider
     */
    public function run($filename, $mime, ActiveDataProvider $dataProvider)
    {
        /*$spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Заголовок 1');
        $sheet->setCellValue('B1', 'Заголовок 2');
        $sheet->setCellValue('A2', 'Привет мир!');
        $sheet->setCellValue('B2', 'Ячейка');

        $writer = new Xlsx($spreadsheet);
        $path = Yii::getAlias('@runtime') . '\\' . $filename;
        $writer->save($path);
        Yii::$app->getResponse()->sendFile($path);*/
        //Yii::$app->getResponse()->sendContentAsFile($writer, $filename, ['mime' => $mime]);
        /*Yii::$app->end();*/
        VarDumper::dump($filename, 10, 1);
        //VarDumper::dump($mime, 10, 1);
        //VarDumper::dump($dataProvider->models, 10, 1);
        die;
        //$this->clearBuffers();

        //Yii::$app->getResponse()->sendContentAsFile($contents, $filename, ['mime' => $mime]);

        //Yii::$app->end();
    }

    /**
     * Clean (erase) the output buffers and turns off output buffering
     */
    protected function clearBuffers()
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    }
}
