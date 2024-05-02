<?php

use yii\db\Migration;

/**
 * Class m240502_103732_add_table_note_tag
 */
class m240502_103732_add_table_note_tag extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE TABLE `note_tag` (
            `id` INT NOT NULL AUTO_INCREMENT , 
            `note_id` INT NOT NULL , 
            `tag_id` INT NOT NULL , 
            `position` INT NOT NULL , 
            PRIMARY KEY (`id`)) ENGINE = InnoDB;
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('note_tag');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240502_103732_add_table_note_tag cannot be reverted.\n";

        return false;
    }
    */
}
