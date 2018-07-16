<?php

namespace modules\catalog\tests\models;

use Yii;
use modules\catalog\tests\fixtures\Category as CategoryFixture;
use modules\catalog\models\CatalogCategory;
use modules\catalog\Module;

/**
 * Class CatalogCategoryTest
 * @package modules\catalog\tests\models
 */
class CatalogCategoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \modules\catalog\tests\UnitTester
     */
    protected $tester;

    /**
     * Array this Fixtures Nested Sets
     * @var array
     */
    public $result = [
        1 => 'Root',
        2 => '- Category 1',
        3 => '- - Child 1-1',
        4 => '- Category 2',
        5 => '- - Child 2-1', // Draft
        6 => '- - Child 2-2',
    ];

    protected function _before()
    {
        $this->tester->haveFixtures([
            'category' => [
                'class' => CategoryFixture::className(),
                'dataFile' => codecept_data_dir() . 'category.php'
            ],
        ]);
    }

    protected function _after()
    {
    }

    /**
     * Test getStatusLabelName()
     * check
     * getStatusName()
     * getLabelsArray()
     * getStatusesArray()
     */
    public function testGetStatusLabelName()
    {
        $category = $this->tester->grabFixture('category', 1);
        expect($category->getStatusLabelName())->equals('<span class="label label-success">' . Module::t('module', 'Published') . '</span>');
        $category = $this->tester->grabFixture('category', 4);
        expect($category->getStatusLabelName())->equals('<span class="label label-default">' . Module::t('module', 'Draft') . '</span>');
    }

    /**
     * Test getSelectArray()
     * check
     * getCategoriesAll()
     */
    public function testGetSelectArray()
    {
        $category = new CatalogCategory();
        // Должны получить такой же результат как в переменной $this->result
        expect($category->getSelectArray())->equals($this->result);

        $result = [
            0 => Module::t('module', '- Select category -')
        ];
        $this->tester->haveFixtures([
            'empty' => [
                'class' => CategoryFixture::className(),
                'dataFile' => codecept_data_dir() . 'empty.php'
            ],
        ]);
        // Должны получить такой же результат как в переменной $result
        expect($category->getSelectArray())->equals($result);
    }

    /**
     * Test getSelectChildArray()
     */
    public function testGetSelectChildArray()
    {
        $result = [
            2 => '>>> Category 1',
            4 => 'Category 2',
        ];
        $category = $this->tester->grabFixture('category', 1);
        // Должны получить такой же результат как в переменной $result
        expect($category->getSelectChildArray())->equals($result);
    }

    /**
     * Test getRenderTree()
     * check
     * getCategories()
     */
    public function testGetRenderTree()
    {
        $result = [
            0 => '<ul>' . PHP_EOL,
            1 => '<li>' . PHP_EOL,
            2 => 'Category 1' . PHP_EOL,
            3 => '<ul>' . PHP_EOL,
            4 => '<li>' . PHP_EOL,
            5 => 'Child 1-1' . PHP_EOL,
            6 => '</li>' . PHP_EOL,
            7 => '</ul>' . PHP_EOL,
            8 => '</li>' . PHP_EOL,
            9 => '<li>' . PHP_EOL,
            10 => 'Category 2' . PHP_EOL,
            11 => '<ul>' . PHP_EOL,
            12 => '<li>' . PHP_EOL,
            13 => 'Child 2-2' . PHP_EOL,
            14 => '</li>' . PHP_EOL,
            15 => '</ul>' . PHP_EOL,
            16 => '</li>' . PHP_EOL,
            17 => '</ul>' . PHP_EOL,
        ];
        $category = new CatalogCategory();
        $depth = 0;
        expect($category->getRenderTree($depth))->equals($result);
    }

    /**
     * Test getSlugCategoryPosition()
     */
    /*public function testGetSlugCategoryPosition()
    {
        $category = new CatalogCategory();
        expect($category->getSlugCategoryPosition())->equals([]);
        expect($category->getSlugCategoryPosition('category_2'))->equals([]);
    }*/
}
