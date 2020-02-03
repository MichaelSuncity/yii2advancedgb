<?php


namespace frontend\controllers;

use common\models\Task;
use Yii;
use yii\web\Controller;


class CalendarController extends Controller
{
    public function actionIndex()
    {
        $events = Task::findAll(['author_id' => Yii::$app->user->id]);

        $events = array_map(function (Task $event){
            return $event->toEvent();
        }, $events);

        return $this->render('month', compact('events'));
    }
}