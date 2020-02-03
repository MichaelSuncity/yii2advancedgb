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
 * @var \common\models\TaskAttachmentsAddForm $taskAttachmentForm
 * @var  $taskCommentForm
 * @var  $isSubscribed boolean

 */
$this->title = 'Задача № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?php if (!$isSubscribed) { ?>
        <?= Html::a('Subscribe', ['subscribe', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php } else { ?>
        <?= Html::a('Unsubscribe', ['unsubscribe', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
    <?php } ?>
</p>
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

<p><?= Html::a('Редактировать задачу', Url::to(['/task/update', 'id' => $model->id]), ['class' => 'btn btn-success'] )  ?></p>

<div class="attachments">
    <h3>Вложения</h3>
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['task/addattachment']),
        'options' => ['class' => "form-inline"]
    ]);?>
    <?=$form->field($taskAttachmentForm, 'task_id')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskAttachmentForm, 'attachment')->fileInput();?>
    <?=Html::submitButton("Добавить",['class' => 'btn btn-success']);?>
    <?ActiveForm::end()?>
    <hr>
    <div class="attachments-history">
        <?foreach ($model->taskAttachments as $file): ?>
            <a href="/img/task/<?=$file->path?>">
                <img src="/img/task/small/<?=$file->path?>" alt="">
            </a>
        <?php endforeach;?>
    </div>
    <h3>Комментарии</h3>
    <div class="comment-history">
        <?foreach ($model->taskComments as $comment): ?>
            <p><strong><?=$comment->user->username?></strong>: <?=$comment->content?></p>
        <?php endforeach;?>
    </div>
    <?php
    $form = ActiveForm::begin(['action' => Url::to(['task/addcomment'])]);?>
    <?=$form->field($taskCommentForm, 'user_id')->hiddenInput(['value' => \Yii::$app->user->identity->getId()])->label(false);?>
    <?=$form->field($taskCommentForm, 'task_id')->hiddenInput(['value' => $model->id])->label(false);?>
    <?=$form->field($taskCommentForm, 'content')->textInput();?>
    <?=Html::submitButton("Отправить",['class' => 'btn btn-success']);?>
    <?ActiveForm::end()?>
</div>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>

<?=\frontend\widgets\chat\Chat::widget(['task_id' => $model->id])?>

