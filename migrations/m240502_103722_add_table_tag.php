<?php

use yii\db\Migration;

/**
 * Class m240502_103722_add_table_tag
 */
class m240502_103722_add_table_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `tag` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `name` VARCHAR(255) NOT NULL , 
            `user_id` INT NOT NULL , 
            `created_at` INT NOT NULL , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240502_103722_add_table_tag cannot be reverted.\n";

        return false;
    }
    */
}
