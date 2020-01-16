<?php


namespace frontend\models;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;
use yii\helpers\Url;
use common\models\User;

    /**
     * Class Task
     * @package frontend\models
     *
     * @property-read  User $user
     * @property $dayStart
     * @property $dayEnd
     * @property $title
     * @property $description
     * @property $userID
     * @property $id
     * @param $strValue
     *
    */


class Task extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'userID',
                'updatedByAttribute' => 'userID',
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
            'title' => 'Название',
            'dayStart' => 'Дата начала',
            'dayEnd' => 'Дата окончания',
            'userID' => 'Пользователь',
            'description' => 'Описание',
            'status' => 'Статус',
        ];
    }

    public function rules()
    {
        return [
            [['title', 'dayStart', 'description', 'status'], 'required'],
            [['title', 'description'], 'string'],
            [['title'], 'string', 'min' => 2, 'max' => 160],
            [['description'], 'string', 'min'=> 5],
            [['dayStart', 'dayEnd'], 'date', 'format' =>'php:Y-m-d'],
            [['userID'], 'integer'],
            [['status'], 'number'],
            ['dayEnd', 'default', 'value' => function(){
                return $this->dayStart;
            }],
            ['dayEnd','checkDayEnd']
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

    public function getUser()
    {
        return $this -> hasOne(User::class, ['id' => 'userID']);
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