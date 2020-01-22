<?php


namespace frontend\controllers;


use common\models\Task;
use yii\web\Controller;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\QueryBuilder;
use yii\filters\PageCache;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use frontend\models\search\TaskSearch;


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
                        'actions' => ['index', 'create', 'view', 'update', 'delete'],
                        'roles' => ['@']
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
       /* $cacheKey = "activity_{$id}";
        if(Yii::$app->cache->exists($cacheKey)){
            $model = Yii::$app->cache->get($cacheKey);
        } else {
            $model = Task::findOne($id);
            Yii::$app->cache->set($cacheKey, $model);
        }*/
        $model = Task::findOne($id);
        if (Yii::$app->user->can('manager') || Yii::$app->user->can('admin') || $model->author_id == Yii::$app->user->id) {
            return $this->render('view',
                compact('model'));
        }  else {
            throw new NotFoundHttpException();
        }
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
            if ($model->author_id == Yii::$app->user->id) {
                if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                    if ($model->save()) {
                        return $this->redirect(["task/view?id=$model->id"]);
                    }
                }

                $templates = Task::find()->where(['is_template'=>true])->all();
                $templates = ArrayHelper::map($templates, 'id', 'title');

                return $this->render('update', [
                    'model' => $model,
                    'templates'=>[]

                ]);
            } else {
                throw new NotFoundHttpException();
            }
        }
    }

    public function actionDelete(int $id )
    {
        $model = Task::findOne($id);
        if (Yii::$app->user->can('manager') || Yii::$app->user->can('admin') || $model->author_id == Yii::$app->user->id) {
            $model->delete();
            return $this->redirect(['index']);
        }else{
            throw new NotFoundHttpException();
        }
    }
}