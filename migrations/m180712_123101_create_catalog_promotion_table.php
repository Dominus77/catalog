<?php

namespace modules\catalog\migrations;

use yii\db\Migration;

/**
 * Class m180712_123101_create_catalog_promotion_table
 * @package modules\catalog\migrations
 */
class m180712_123101_create_catalog_promotion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%catalog_promotion}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->comment('Name'),
            'description' => $this->text()->comment('Description'),
            'discount' => $this->integer()->defaultValue(0)->comment('Discount'),
            'status' => $this->smallInteger(2)->defaultValue(0)->comment('Status'),
            'start_at' => $this->integer()->comment('Start'),
            'end_at' => $this->integer()->comment('End'),
            'created_at' => $this->integer()->notNull()->comment('Created'),
            'updated_at' => $this->integer()->notNull()->comment('Updated'),
        ]);

        // Table relations Promotions Product
        $this->createTable('{{%catalog_promotion_product}}', [
            'promotion_id' => $this->integer()->comment('ID Promotion'),
            'product_id' => $this->integer()->comment('ID Product'),
        ], $tableOptions);

        $this->createIndex('IDX_catalog_promotion', '{{%catalog_promotion_product}}', 'promotion_id');
        $this->addForeignKey(
            'FK_catalog_promotion', '{{%catalog_promotion_product}}', 'promotion_id', '{{%catalog_promotion}}', 'id'
        );

        $this->createIndex('IDX_catalog_product', '{{%catalog_promotion_product}}', 'product_id');
        $this->addForeignKey(
            'FK_catalog_product', '{{%catalog_promotion_product}}', 'product_id', '{{%catalog_product}}', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%catalog_promotion_product}}');
        $this->dropTable('{{%catalog_promotion}}');
    }
}
