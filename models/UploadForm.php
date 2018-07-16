<?php

namespace modules\catalog\models;

use yii\base\Model;
//use yii\web\UploadedFile;
use yii\imagine\Image;
use modules\catalog\Module;
use yii\helpers\VarDumper;

/**
 * Class UploadForm
 * @package modules\portfolio\models
 */
class UploadForm extends Model
{
    public $imageFiles;

    public $dir;
    public $size;
    public $quality;
    public $oldFile;
    public $ext;
    public $maxFiles;

    private $_path;

    public function init()
    {
        parent::init();
        $this->dir = $this->dir ? $this->dir : Module::$uploadDir;
        $this->size = $this->size ? $this->size : Module::$imageSize;
        $this->quality = $this->quality ? $this->quality : Module::$imageQuality;
        $this->ext = $this->ext ? $this->ext : Module::$imageExt;
        $this->maxFiles = $this->maxFiles ? $this->maxFiles : Module::$maxFiles;
        $this->_path = $this->getDir();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => $this->ext, 'maxFiles' => $this->maxFiles],
            [['dir'], 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'imageFiles' => Module::t('module', 'Image files'),
        ];
    }

    /**
     * @return string
     */
    protected function getDir()
    {
        return \Yii::getAlias('@upload') . '/' . $this->dir;
    }

    /**
     * Upload files
     *
     * @return array|bool
     */
    public function upload()
    {
        if ($this->validate()) {

            $this->processMkDir();

            $filesNames = [];
            /** @var $file \yii\web\UploadedFile $file */
            foreach ($this->imageFiles as $file) {
                $name = md5_file($file->tempName) . '.' . $file->extension; //$file->imageFile->baseName
                $tmp = '_' . $name;
                if ($this->size) {
                    if ($file->saveAs($this->_path . '/' . $tmp)) {
                        Image::thumbnail($this->_path . '/' . $tmp, $this->size[0], $this->size[1])
                            ->save($this->_path . '/' . $name, ['quality' => $this->quality]);

                        chmod($this->_path . '/' . $name, 0755);

                        if (file_exists($this->_path . '/' . $tmp))
                            unlink($this->_path . '/' . $tmp);
                        $filesNames[] = $name;
                    }
                } else {
                    if ($file->saveAs($this->_path . '/' . $name)) {
                        chmod($this->_path . '/' . $name, 0755);
                        $filesNames[] = $name;
                    }
                }
            }
            return $filesNames;

        }
        return null;
    }

    /**
     * @return null
     */
    public function delete()
    {
        if (isset($this->oldFile) && !empty($this->oldFile)) {
            $path = $this->_path . '/' . $this->oldFile;
            if (file_exists($path))
                unlink($path);
            // Если папка пустая, удаляем.
            if ([] === (array_diff(scandir($this->_path), ['.', '..']))) {
                rmdir($this->_path);
            }
        }
        return true;
    }

    /**
     * Check and create dir
     */
    protected function processMkDir()
    {
        if (!file_exists($this->_path)) {
            mkdir($this->_path, 0777, true);
        }
        return null;
    }
}