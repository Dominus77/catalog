<?php

namespace modules\catalog\widgets\tree_menu;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

/**
 * Class TreeMenuWidget
 * @package modules\catalog\widgets\tree_menu
 */
class TreeMenu extends Widget
{
    public $id;
    public $depthStart = 1;
    public $dataTree = null;
    public $message = 'No categories.';
    public $active = null;


    public function init()
    {
        parent::init();
        $this->id = $this->id ? $this->id : $this->getId();
    }

    public function run()
    {
        if ($tree = self::getRenderTree()) {
            $this->registerAssets();
            foreach ($tree as $items) {
                echo $items . PHP_EOL;
            }
        } else {
            echo $this->message;
        }
    }

    /**
     * Render List Tree
     * @return array
     */
    protected function getRenderTree()
    {
        $array = [];
        if ($query = $this->dataTree) {
            $depth = $this->depthStart;
            $i = 0;
            echo Html::beginTag('ul', ['id' => $this->id, 'class' => 'ul-treefree ul-dropfree']) . PHP_EOL;
            foreach ($query as $n => $category) {
                if ($category->depth == $depth) {
                    $array[] = $i ? Html::endTag('li') . PHP_EOL : '';
                } else if ($category->depth > $depth) {
                    $array[] = Html::beginTag('ul') . PHP_EOL;
                } else {
                    $array[] = Html::endTag('li') . PHP_EOL;
                    for ($i = $depth - $category->depth; $i; $i--) {
                        $array[] = Html::endTag('ul') . PHP_EOL;
                        $array[] = Html::endTag('li') . PHP_EOL;
                    }
                }
                $array[] = Html::beginTag('li') . PHP_EOL;
                $array[] = self::getItemActive($category) . PHP_EOL;
                $depth = $category->depth;
                $i++;
            }
            for ($i = $depth; $i; $i--) {
                $array[] = Html::endTag('li') . PHP_EOL;
                $array[] = Html::endTag('ul') . PHP_EOL;
            }
        }
        return $array;
    }

    /**
     * @param $data
     * @return string
     */
    private function getItemActive($data)
    {
        if ($this->active == $data->id) {
            return Html::tag('strong', $data->name, []);
        } else {
            return Html::a($data->name, ['default/category', 'id' => $data->id, 'slug' => $data->slug], []);
        }
    }

    /**
     * Register resource
     */
    private function registerAssets()
    {
        $view = $this->getView();
        TreeMenuAsset::register($view);
    }
}