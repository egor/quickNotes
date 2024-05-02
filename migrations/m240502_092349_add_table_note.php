<?php

use yii\db\Migration;

/**
 * Class m240502_092349_add_table_note
 */
class m240502_092349_add_table_note extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `note` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `user_id` INT NOT NULL , 
            `created_at` INT NOT NULL , 
            `updated_at` INT NOT NULL , 
            `user_date` INT NOT NULL , 
            `header` VARCHAR(255) NOT NULL , 
            `description` TEXT NOT NULL , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('note');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240502_092349_add_table_note cannot be reverted.\n";

        return false;
    }
    */
}
