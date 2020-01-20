<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%task}}`.
 */
class m200119_190809_add_is_template_and_priority_and__executor_columns_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task','executor_id', $this->integer()->comment('Исполнитель'));
        $this->addColumn('task','priority_id', $this->tinyInteger()->comment('Приоритет'));
        $this->addColumn('task','is_template', $this->boolean()->comment('Это шаблон?'));
        $this->addColumn('task','template_id', $this->integer());

        $this->addForeignKey(
            'fk-task-executor_id',
            'task',
            'executor_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-template-id_task',
            'task', 'template_id',
            'task', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('task', 'executor_id');
        $this->dropColumn('task', 'priority_id');
        $this->dropColumn('task', 'is_template');
        $this->dropColumn('task', 'template_id');

        $this->dropForeignKey('fk-task-executor_id', 'task');
        $this->dropForeignKey('fk-template-id_task', 'task');
    }
}
