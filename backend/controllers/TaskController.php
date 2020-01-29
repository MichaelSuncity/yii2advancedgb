<?php

namespace backend\controllers;

use common\models\Task;
use yii\web\Controller;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use backend\models\search\TaskSearch;
use common\models\TaskAttachmentsAddForm;
use common\models\TaskComments;
use yii\web\UploadedFile;
use common\models\TaskSubscriber;

class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class, //ACF
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'view', 'update', 'delete',
                            'addattachment', 'addcomment', 'subscribe', 'unsubscribe'],
                        'roles' => ['admin']
                    ],
                ],
            ],
        ];
    }


    public function actionIndex($sort = false)
    {
        $searchModel = new TaskSearch();
        $provider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $searchModel,
        ]);
    }



    public function actionView(int $id) {
        $model = Task::findOne($id);
        $isSubscribed = TaskSubscriber::isSubscribed(\Yii::$app->user->id, $id);
            return $this->render('view',
                ['model' => $model,
                    'isSubscribed' => $isSubscribed,
                    'taskAttachmentForm' => new TaskAttachmentsAddForm(),
                    'taskCommentForm' => new TaskComments(),
                ]);
    }

    public function actionCreate(){
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $templates = Task::find()->where(['is_template'=>true])->all();
        $templates = ArrayHelper::map($templates, 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'templates'=>$templates
        ]);
    }

    public function actionUpdate(int $id = null)
    {
        if (!empty($id)) {
            $model = Task::findOne($id);
                if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                    if ($model->save()) {
                        return $this->redirect(['task/view', 'id' => $model->id]);
                    }
                }

                $templates = Task::find()->where(['is_template'=>true])->all();
                $templates = ArrayHelper::map($templates, 'id', 'title');

                return $this->render('update', [
                    'model' => $model,
                    'templates'=>[]
                ]);
        }
    }

    public function actionDelete(int $id )
    {
        $model = Task::findOne($id);
            $model->delete();
            return $this->redirect(['index']);
    }


    public function actionAddattachment()
    {
        $model = new TaskAttachmentsAddForm();
        $model->load(\Yii::$app->request->post());
        $model->attachment = UploadedFile::getInstance($model, 'attachment');
        if ($model->save()) {
            \Yii::$app->session->setFlash('success', "Файл добавлен");
        } else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить файл");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddcomment()
    {
        $model = new TaskComments();
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', "Комментарий добавлен");
        } else {
            \Yii::$app->session->setFlash('error', "Не удалось добавить комментарий");
        }
        $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionSubscribe($id)
    {
        if (TaskSubscriber::subscribe(\Yii::$app->user->id, $id)) {
            Yii::$app->session->setFlash('success', 'Subscribed');
        } else {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(['task/view', 'id' => $id]);
    }

    public function actionUnsubscribe($id)
    {
        if (TaskSubscriber::unsubscribe(\Yii::$app->user->id, $id)) {
            Yii::$app->session->setFlash('success', 'Subscribed');
        } else {
            Yii::$app->session->setFlash('error', 'Error');
        }
        $this->redirect(['task/view', 'id' => $id]);
    }
}