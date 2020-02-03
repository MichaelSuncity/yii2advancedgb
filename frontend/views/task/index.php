<?php
use common\models\Task;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
/**
 * @var $this yii\web\View
 * @var \common\models\Task[] $task
 * @var $searchModel frontend\models\search\TaskSearch
 * @var $provider \yii\data\ActiveDataProvider
 *
 */

$columns = [
    [
        'class' => SerialColumn::class,
        'header' => 'Псевдо-порядковый класс',
    ],
    [
        'label' => 'Порядковый номер',
        'attribute' => 'id',
    ],
    [
        'label' => 'Название задачи',
        'attribute' => 'title',
    ],
        'dayStart:date',
        'dayEnd:date',
    [
        'label' => 'Имя создателя',
        'attribute' => 'author_id',
        'value' => function (Task $model)
        {
            return $model->author->username;
        }
    ],
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
];
if (Yii::$app->user->can('user')){
    $columns[]=[
        'class' => ActionColumn::class,
        'header' => 'Operations',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view' => function ($url, Task $model) {
                return html::a( '', Url::to(['/task/view', 'id' => $model->id]), ['class' => 'glyphicon glyphicon-eye-open']);
            },
             'update' => function ($url, Task $model){
                return html::a('', Url::to(['/task/update', 'id' => $model->id]), ['class' => 'glyphicon glyphicon-pencil']);
            },
            'delete' => function ($url, Task $model){
                return html::a('', Url::to(['/task/delete', 'id' => $model->id]), ['class' => 'glyphicon glyphicon-trash']);
            }
        ],
    ];
}

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>



<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
    'columns'=> $columns,
])?>




<?php $form = ActiveForm::begin([
    'action' => '/task/create',
])?>

<p><?= Html::submitButton('Добавить задачу', ['class' => 'btn btn-success']) ?></p>

<?php ActiveForm::end()?>


