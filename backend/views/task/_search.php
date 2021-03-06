<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\TaskSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="task-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        /*'options' => [
            'data-pjax' => 1
        ],*/
    ]); ?>

    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'dayStart')->textInput(['type' => 'date'])?>
    <?= $form->field($model, 'dayEnd')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'author_id') ?>
    <?= $form->field($model, 'executor_id') ?>
    <?= $form->field($model, 'priority_id') ?>
    <?= $form->field($model, 'status') ?>


    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>