<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\account\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'dayStart',
            'dayEnd',
            [
                'label' => 'Имя создателя',
                'attribute' => 'author_id',
                'value' => function (Task $model)
                {
                    return $model->author->username;
                }
            ],
            //'description:ntext',
            //'created_at',
            //'updated_at',
            [
                'label' => 'Имя исполнителя',
                'attribute' => 'executor_id',
                'value' => function (Task $model)
                {
                    return $model->executor->username;
                }
            ],
            [
                'label' => 'Приоритет',
                'attribute'=>'priority_id',
                'value'=>function(Task $model) {
                    return $model->priority->title;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function(Task $model) {
                    return Task::getStatusName()[$model->status];
                }
            ],
            //'is_template',
            //'template_id',
            //'project_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
