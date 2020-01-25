<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_attachments}}`.
 */
class m200125_101826_create_task_attachments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_attachments}}', [
            'id' => $this->primaryKey(),
            'task_id' => $this->integer(),
            'path' => $this->string()
        ]);
        $this->addForeignKey(
            'fk-image-task_id',
            'task_attachments',
            'task_id',
            'task',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_attachments}}');
        $this->dropForeignKey('fk-image-task_id','task_attachments');
    }
}
