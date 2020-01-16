
<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\Task;
use yii\web\View;
use yii\helpers\Url;

/**
 * @var  View $this
 * @var  Task $model
 *
 */

?>

<h1>Создать задачу</h1>
<?php $form = ActiveForm::begin([
    'action' => '/task/submit',
])?>

<?= $form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
<?= $form->field($model, 'dayStart')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'dayEnd')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
<?= $form->field($model, 'status')->textInput(['type' => 'number']) ?>

<p><?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?></p>

<?php ActiveForm::end()?>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>