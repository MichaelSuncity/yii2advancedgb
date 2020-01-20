<?php

use yii\db\Migration;

/**
 * Class m200119_184743_rename_userID_column_in_task_table
 */
class m200119_184743_rename_userID_column_in_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('task','userID',  'author_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('task','author_id',  'userID');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200119_184743_rename_userID_column_in_task_table cannot be reverted.\n";

        return false;
    }
    */
}
