<?php


namespace common\models;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Url;
use common\models\User;
use frontend\models\ChatLog;

    /**
     * Class Task
     * @package frontend\models
     *
     * @property-read  User $author
     * @property-read  User $executor
     * @property $dayStart
     * @property $dayEnd
     * @property string|null  $title
     * @property string|null $description
     * @property int|null $author_id
     * @property int|null $executor_id
     * @property int|null $priority_id
     * @property int|null $status
     * @property int|null $template_id
     * @property int|null $project_id
     * @property boolean $is_template
     * @property int $id
     * @property Task $template
     * @property Priority $priority
     * @property Project $project
     * @param $strValue
     *
    */


class Task extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_DONE = 3;

    public function beforeValidate()
    {
        if (!empty($this->template_id)) {
            $template = $this->template;
            $this->description = $template->description;
            $this->title = $template->title;
        }

        return parent::beforeValidate();
    }

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

    public static function tableName()
    {
        return 'task';
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название задачи',
            'dayStart' => 'Дата начала',
            'dayEnd' => 'Дата окончания',
            'author_id' => 'Создатель',
            'executor_id' => 'Исполнитель',
            'priority_id' => 'Приоритет',
            'template_id' => 'Шаблон',
            'project_id' => 'Проект',
            'description' => 'Описание',
            'status' => 'Статус',
            'is_template' => 'Использовать в качестве шаблона?',
            'created_at' => 'Дата создания задачи',
            'updated_at' => 'Дата обновления задачи',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'dayStart', 'description', 'status', 'executor_id', 'priority_id', 'project_id'], 'required'],
            [['title', 'description'], 'string'],
            [['title'], 'string', 'min' => 2, 'max' => 160],
            [['description'], 'string', 'min'=> 5],
            [['dayStart', 'dayEnd'], 'date', 'format' =>'php:Y-m-d'],
            [['author_id', 'executor_id', 'template_id'], 'integer'],
            [['status','priority_id', 'project_id'], 'integer'],
            ['dayEnd', 'default', 'value' => function(){
                return $this->dayStart;
            }],
            ['dayEnd','checkDayEnd'],
            [['is_template'], 'boolean'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['executor_id' => 'id']],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::class, 'targetAttribute' => ['template_id' => 'id']],
            [['priority_id'], 'exist', 'skipOnError' => false, 'targetClass' => Priority::class, 'targetAttribute' => ['priority_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => false, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    public function checkDayEnd($strValue)
    {
        $dayStart = strtotime($this->dayStart);
        $dayEnd = strtotime($this->$strValue);
        if ($dayEnd < $dayStart) {
            $this->addError($strValue, 'Дата окончания события не может быть раньше даты его начала!');
        }
    }



    /**
     * @return \yii\db\ActiveQuery
     */

    public function getAuthor()
    {
        return $this -> hasOne(User::class, ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getExecutor()
    {
        return $this -> hasOne(User::class, ['id' => 'executor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getTemplate()
    {
        return $this -> hasOne(Task::class, ['id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getProject()
    {
        return $this -> hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getPriority()
    {
        return $this->hasOne(Priority::class, ['id' => 'priority_id'])->where(['priority.type'=>Priority::TYPE_TASK]);
    }



    public static function getStatusName()
    {
        return [
            static::STATUS_NEW => "New",
            static::STATUS_IN_PROGRESS => "In progress",
            static::STATUS_DONE => "Done",
        ];
    }

    public function afterSave($insert, $changedAttribute)
    {
        $message = $insert ? '<b>создал(а) задачу № : ' . $this->id : '<b>обновил(а) задачу № : ' . $this->id;
            ChatLog::create([
                'username' => Yii::$app->user->identity->username,
                'message' => $message,
                'task_id' => $this->id,
                'type' => ChatLog::SEND_MESSAGE,
            ]);
    }
/*
    public static function findOne($condition)
    {
        if(Yii::$app->cache->exists('activity_'.$condition)){
            return Yii::$app->cache->get('activity_'.$condition);
        }else{
            $model = parent::findOne($condition);
            Yii::$app->cache->set('activity_'.$condition, $model);
            return $model;
        }
    }
*/
    public function toEvent()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->dayStart,
            'end' => $this->dayEnd,
            'url' => Url::to(['/task/view', 'id' => $this->id]),
        ];
    }

}