<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\DetailView;


/**
 * @var View $this
 * @var Task $model
 */
$this->title = 'Задача № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
    'model' => $model,
    'attributes'=> [
        [
            'label' => 'Порядковый номер',
            'attribute' => 'id',
            'value'=>function (Task $model){
                return "{$model->id}";
            }
        ],
        'title',
        'dayStart:datetime',
        'dayEnd:datetime',
        [
            'label' => 'Описание задачи',
            'attribute' => 'description'
        ],
        [
            'label' => 'Имя создателя',
            'attribute' => 'author.username'
        ],
        [
            'label' => 'Имя исполнителя',
            'attribute' => 'executor.username'
        ],
        [
            'attribute'=>'status',
            'value'=>function(Task $model) {
                return Task::getStatusName()[$model->status];
            }
        ],
        [
            'label' => 'Приоритет',
            'attribute'=>'priority_id',
            'value'=>function(Task $model) {
                return $model->priority->title;
            }
        ],
        'created_at:datetime',
        'updated_at:datetime',
    ],
]) ?>

<p><?= Html::a('Редактировать задачу', "/task/update?id={$model['id']}", ['class' => 'btn btn-success'] )  ?></p>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>

<?=\frontend\widgets\chat\Chat::widget(['task_id' => $model->id])?>

