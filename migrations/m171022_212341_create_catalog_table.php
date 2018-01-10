<?php

namespace modules\catalog\migrations;

use yii\db\Migration;

/**
 * Class m171022_212341_create_catalog_table
 * @package modules\catalog\migrations
 */
class m171022_212341_create_catalog_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * Table Category Nested Set
         */
        $this->createTable('{{%catalog_category}}', [
            'id' => $this->primaryKey()->comment('ID'),
            //'tree' => $this->integer()->comment('Root'),
            'lft' => $this->integer()->notNull()->comment('L.Key'),
            'rgt' => $this->integer()->notNull()->comment('R.Key'),
            'depth' => $this->integer()->notNull()->comment('Depth'),
            'name' => $this->string(80)->notNull()->comment('Name'),
            //'slug' => $this->string()->notNull()->unique()->comment('Alias'),
            'slug' => $this->string()->notNull()->comment('Alias'),
            'description' => $this->text()->comment('Description'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Status'),
            'meta_description' => $this->string(200)->comment('Meta-description'),
            'meta_keywords' => $this->string(250)->comment('Meta-keywords'),
        ], $tableOptions);

        //$this->createIndex('idx_catalog_category_slug', '{{%catalog_category}}', 'slug');
        $this->createIndex('idx_catalog_category_lft', '{{%catalog_category}}', 'lft');
        $this->createIndex('idx_catalog_category_rgt', '{{%catalog_category}}', 'rgt');
        $this->createIndex('idx_catalog_category_depth', '{{%catalog_category}}', 'depth');

        /**
         * Table Products
         */
        $this->createTable('{{%catalog_product}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'code' => $this->string()->unique()->comment('Code'),
            'name' => $this->string()->notNull()->comment('Name'),
            'slug' => $this->string()->notNull()->unique()->comment('Alias'),
            'availability' => $this->integer()->defaultValue(0)->comment('Availability'), // Наличие
            'retail' => $this->decimal(10, 2)->comment('Retail'), // Розница/Стоимость пример: 3200.00
            'description' => $this->text()->comment('Description'),
            'category_id' => $this->integer()->notNull()->comment('Category'),

            'position' => $this->integer()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Status'),
            'meta_description' => $this->string(200)->comment('Meta-description'),
            'meta_keywords' => $this->string(250)->comment('Meta-keywords'),
        ], $tableOptions);

        $this->createIndex('idx_catalog_product_slug', '{{%catalog_product}}', 'slug');
        $this->createIndex('idx_catalog_product_category', '{{%catalog_product}}', 'category_id');
        $this->addForeignKey(
            'FK_catalog_product_category', '{{%catalog_product}}', 'category_id', '{{%catalog_category}}', 'id'
        );

        /**
         * Table Product Images
         */
        $this->createTable('{{%catalog_product_image}}', [
            'id' => $this->primaryKey()->comment('ID'),
            'product_id' => $this->integer()->notNull()->comment('Product'),
            'image' => $this->string()->comment('Image'),

            'position' => $this->integer()->defaultValue(0)->comment('Position'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
            'status' => $this->smallInteger()->notNull()->defaultValue(0)->comment('Status'),
        ], $tableOptions);

        $this->createIndex('idx_catalog_product_image_product', '{{%catalog_product_image}}', 'product_id');
        $this->addForeignKey(
            'FK_catalog_product_image', '{{%catalog_product_image}}', 'product_id', '{{%catalog_product}}', 'id'
        );

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%catalog_product_image}}');
        $this->dropTable('{{%catalog_product}}');
        $this->dropTable('{{%catalog_category}}');
    }
}
