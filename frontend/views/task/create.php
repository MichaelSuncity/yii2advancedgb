
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $templates array */

$this->title = 'Создание задачи';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
        'model' => $model,
        'templates' => $templates
]) ?>

<?php
/*
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;
use yii\web\View;
use yii\helpers\Url;

/**
 * @var  View $this
 * @var  Task $model
 * @var  $templates array
 *
 */

/*
<h1>Создать задачу</h1>

<?php $form = ActiveForm::begin([
    'action' => '/task/submit',
])?>

<?= $form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
<?= $form->field($model, 'dayStart')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'dayEnd')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'executor_id')->textInput() ?>
<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
<?= $form->field($model, 'status')->textInput(['type' => 'number']) ?>
<?= $form->field($model, 'is_template')->checkbox() ?>

<p><?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?></p>

<?php ActiveForm::end()?>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>
*/
?>