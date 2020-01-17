<?php


namespace frontend\controllers;


use frontend\models\Task;
use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\PageCache;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;


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
                        'actions' => ['index', 'create', 'view', 'update', 'delete', 'submit'],
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }


    public function actionIndex($sort = false)
    {
        $query = Task::find();
        if (!Yii::$app->user->can('admin')){
            $query->andWhere(['userID'=>Yii::$app->user->id]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'validatePage' => false
            ]
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }



    public function actionView(int $id) {
       /* $cacheKey = "activity_{$id}";
        if(Yii::$app->cache->exists($cacheKey)){
            $model = Yii::$app->cache->get($cacheKey);
        } else {
            $model = Task::findOne($id);
            Yii::$app->cache->set($cacheKey, $model);
        }*/
        $model = Task::findOne($id);
        if (Yii::$app->user->can('manager') || Yii::$app->user->can('admin') || $model->userID == Yii::$app->user->id) {
            return $this->render('view',
                compact('model'));
        }  else {
            throw new NotFoundHttpException();
        }
    }

    public function actionCreate(){
        $model = new Task();
        return $this->render('create',
            ['model' => $model]
        );
    }

    public function actionUpdate(int $id = null)
    {
        if (!empty($id)) {
            $model = Task::findOne($id);
            if ($model->userID == Yii::$app->user->id) {
                if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                    if ($model->save()) {
                        return $this->redirect(["task/view?id=$model->id"]);
                    }
                }
                return $this->render('edit', [
                    'model' => $model
                ]);
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    public function actionDelete(int $id )
    {
        $model = Task::findOne($id);
        if (Yii::$app->user->can('manager') || Yii::$app->user->can('admin') || $model->userID == Yii::$app->user->id) {
            $model->delete();
            return $this->redirect(['index']);
        }else{
            throw new NotFoundHttpException();
        }
    }

    public function actionSubmit()
    {
        $model = new Task();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
            }
            return $this->redirect(['index']);
        }
    }
}