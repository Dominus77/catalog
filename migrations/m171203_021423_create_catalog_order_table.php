<?php

namespace modules\catalog\migrations;

use yii\db\Migration;

/**
 * Class m171203_021423_create_catalog_order_table
 * @package modules\catalog\migrations
 */
class m171203_021423_create_catalog_order_table extends Migration
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
         * Таблица заказов
         */
        $this->createTable('{{%catalog_order}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string(255)->comment('First Name'),
            'last_name' => $this->string(255)->comment('Last Name'),
            'email' => $this->string(255)->comment('Email'),
            'phone' => $this->string(255)->comment('Phone'),
            'address' => $this->integer(11)->comment('Address'),
            'status' => $this->smallInteger(2)->defaultValue(0)->comment('Status'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
        ], $tableOptions);

        /**
         * Таблица заказов товаров
         */
        $this->createTable('{{%catalog_order_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11)->notNull()->comment('Product'),
            'order_id' => $this->integer(11)->notNull()->comment('Order'),
            'count' => $this->integer(11)->defaultValue(1)->comment('Count'),
            'price' => $this->decimal(10, 2)->comment('Price'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
        ], $tableOptions);

        $this->createIndex('idx_catalog_order', '{{%catalog_order_product}}', 'order_id');
        $this->addForeignKey(
            'FK_catalog_order', '{{%catalog_order_product}}', 'order_id', '{{%catalog_order}}', 'id'
        );
        $this->createIndex('idx_catalog_order_product', '{{%catalog_order_product}}', 'product_id');
        $this->addForeignKey(
            'FK_catalog_order_product', '{{%catalog_order_product}}', 'product_id', '{{%catalog_product}}', 'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%catalog_order_product}}');
        $this->dropTable('{{%catalog_order}}');
    }
}
