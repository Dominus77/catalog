<?php

namespace modules\catalog\models;

use Yii;
use yii\base\Model;
use modules\catalog\Module;

/**
 * Class Import
 * @package modules\catalog\models
 */
class Import extends Model
{
    public $file;
    public $ext = 'xls, xlsx';
    public $maxFiles = 1;
    // Опции импорта
    public $importOptionsCreate; // добавление данных
    public $importOptionsUpdate; // обновление данных
    public $importOptionsDelete; // удаление данных

    public function init()
    {
        parent::init();
        $this->ext = $this->ext ? $this->ext : Module::$importExt;
        $this->maxFiles = $this->maxFiles ? $this->maxFiles : Module::$importMaxFiles;
        $this->importOptionsCreate = $this->importOptionsCreate ? $this->importOptionsCreate : true;
        $this->importOptionsUpdate = $this->importOptionsUpdate ? $this->importOptionsUpdate : true;
        $this->importOptionsDelete = $this->importOptionsDelete ? $this->importOptionsDelete : false;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => $this->ext, 'maxFiles' => $this->maxFiles],
            [['importOptionsCreate', 'importOptionsUpdate', 'importOptionsDelete'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => Module::t('module', 'File'),
            'importOptionsCreate' => Module::t('module', 'Create Line Items'),
            'importOptionsUpdate' => Module::t('module', 'Update Line Items'),
            'importOptionsDelete' => Module::t('module', 'Delete Line Items'),
        ];
    }
}
