<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "project".
 *@property-read  User $author
 *@property-read  Priority $priority

 * @property int $id
 * @property int|null $author_id
 * @property int|null $priority_id
 * @property string|null $title
 * @property string|null $description
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Task[] $tasks
 */
class Project extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_DONE = 3;

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'author_id',
            ],
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'priority', 'status', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Создатель',
            'title' => 'Название проекта',
            'description' => 'Описание',
            'priority' => 'Приоритет',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class(), [ 'project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id', 'type' => Priority::TYPE_PROJECT]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getAuthor()
    {
        return $this -> hasOne(User::class, ['id' => 'author_id']);
    }

    public static function getStatusName()
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_IN_PROGRESS => "In progress",
            static::STATUS_DONE => "Done",
        ];
    }
}