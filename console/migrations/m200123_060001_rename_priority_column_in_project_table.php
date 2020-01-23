<?php

use yii\db\Migration;

/**
 * Class m200123_060001_rename_priority_column_in_project_table
 */
class m200123_060001_rename_priority_column_in_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('project','priority',  'priority_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('project','priority_id',  'priority');
    }
}
