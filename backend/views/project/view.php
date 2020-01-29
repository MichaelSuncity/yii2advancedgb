<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use \common\models\Project;


/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($this->title) ?></h1>


<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Порядковый номер',
                'attribute' => 'id',
                'value'=>function (Project $model){
                    return "{$model->id}";
                }
            ],
            [
                'label' => 'Имя создателя',
                'attribute' => 'author.username'
            ],
            'title',
            'description:ntext',
            [
                'label' => 'Приоритет',
                'attribute'=>'priority_id',
                'value'=>function(Project $model) {
                    return $model->priority->title;
                }
            ],
            [
                'attribute'=>'status',
                'value'=>function(Project $model) {
                    return Project::getStatusName()[$model->status];
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'is_parent',
                'label' => 'Это материнский проект?',
                'value' => function (common\models\Project $model) {
                    return $model->is_parent ? "Да" : "Нет";
                },
            ],
            [
                'attribute' => 'parent_project_id',
                'label' => 'Какой у него материнский проект?',
                'format' => 'raw',
                'value' => function (common\models\Project $model) {
                    return Html::a($model->parent_project_id, ['/project/view', 'id' => $model->parent_project_id]);
                }
            ],
        ],
]) ?>


<p><?= Html::a('Редактировать проект', Url::to(['/project/update', 'id' => $model->id]), ['class' => 'btn btn-success'] )  ?></p>

<?= $this->render('/task/index', compact('provider'))?>

<p><?= Html::a('Вернуться в список проектов', Url::to(['/project/index']) ) ?></p>

<?=\frontend\widgets\chat\Chat::widget(['project_id' => $model->id])?>

