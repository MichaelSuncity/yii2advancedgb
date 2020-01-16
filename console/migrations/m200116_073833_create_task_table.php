<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m200116_073833_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this -> string()->notNull()->comment('Название задачи'),
            'dayStart' => $this ->string()->comment('Дата начала'),
            'dayEnd' => $this -> string()->comment('Дата окончания'),
            'userID' => $this -> integer()->comment('Создатель'),
            'description' => $this -> text()->comment('Описание'),
            'status' => $this -> tinyInteger()->comment('Статус'),
            'created_at' => $this -> Integer(),
            'updated_at' => $this -> Integer(),
        ]);

        $this->addForeignKey(
            'fk-task-userID',
            'task',
            'userID',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-task-userID', 'task');
        $this->dropTable('{{%task}}');
    }
}
