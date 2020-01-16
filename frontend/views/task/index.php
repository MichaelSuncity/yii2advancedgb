<?php
use frontend\models\Task;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\grid\ActionColumn;
/**
 * @var $this yii\web\View
 * @var \frontend\models\Task[] $task
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
    'dayStart:datetime',
    'dayEnd:datetime',
    [
        'label' => 'Имя создателя',
        'attribute' => 'userID',
        'value' => function (Task $model)
        {
            return $model->user->username;
        }
    ],
    [
        'label' => 'Статус',
        'attribute' => 'status',
    ],
];
if (Yii::$app->user->can('user')){
    $columns[]=[
        'class' => ActionColumn::class,
        'header' => 'Операции',
        'template' => '{view} {update} {delete} {edit}'
    ];
}
?>

<h1>Список задач</h1>



<?= GridView::widget([
    'dataProvider' => $provider,
    'columns'=> $columns,
])?>




<?php $form = ActiveForm::begin([
    'action' => '/task/create',
])?>

<p><?= Html::submitButton('Добавить задачу', ['class' => 'btn btn-success']) ?></p>

<?php ActiveForm::end()?>


