<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use common\models\Project;
use common\models\Priority;
use yii\grid\ActionColumn;



/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/*  @var \common\models\Project[] $project*/

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => SerialColumn::class,
                'header' => 'Псевдо-порядковый класс',
            ],
            [
                'label' => 'Порядковый номер',
                'attribute' => 'id',
            ],
            [
                'class' => ActionColumn::class,
                'header' => 'Название проекта',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model){
                        return html::a("{$model->title}", $url);
                    }
                ],
            ],
            [
                'label' => 'Описание',
                'attribute' => 'description',
            ],
            [
                'label' => 'Имя создателя',
                'attribute' => 'author_id',
                'value' => function (Project $model) {
                    return $model->author->username;
                }
            ],
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
            //'created_at:datetime',
            //'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <p>
        <?= Html::a('Добавить проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
