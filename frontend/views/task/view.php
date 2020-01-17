<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Task;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\DetailView;


/**
 * @var View $this
 * @var Task $model
 */
?>
<h1>Задача № <?= $model->id?></h1>


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
        'dayEnd:date',
        [
            'label' => 'Описание задачи',
            'attribute' => 'description'
        ],
        [
            'label' => 'Имя создателя',
            'attribute' => 'user.username'
        ],
        [
            'label' => 'Статус задачи',
            'attribute' => 'status',
        ],
        [
            'label' => 'Дата создания задачи',
            'attribute' => 'created_at',
        ],
        [
            'label' => 'Дата обновления задачи',
            'attribute' => 'updated_at',
        ],
    ],
]) ?>

<p><?= Html::a('Редактировать задачу', "/task/update?id={$model['id']}", ['class' => 'btn btn-success'] )  ?></p>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>
