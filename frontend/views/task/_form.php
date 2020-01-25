<?php
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;
use common\models\Priority;
use common\models\Project;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
/* @var $templates array */

/*
<?= $form->field($model, 'project_id')->dropDownList(Task::getProject()) ?>
 * */

?>


<?php $form = ActiveForm::begin(); ?>
<?php if (!empty($templates)) { ?>
    <?= $form->field($model, 'template_id')->dropDownList($templates, ['prompt'=>'Без шаблона']) ?>
<?php } ?>

<?= $form->field($model, 'project_id')->textInput()->dropDownList(\common\models\Project::getProjectNames()) ?>
<?= $form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
<?= $form->field($model, 'dayStart')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'dayEnd')->textInput(['type' => 'date']) ?>
<?= $form->field($model, 'executor_id')->textInput()->dropDownList(\common\models\User::getUsernames()) ?>
<?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
<?= $form->field($model, 'priority_id')->textInput()->dropDownList(Priority::getTaskPriorities()) ?>
<?= $form->field($model, 'status')->dropDownList(Task::getStatusName()) ?>



<?= $form->field($model, 'is_template')->checkbox() ?>

<p><?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?></p>


<?php ActiveForm::end(); ?>

<p><?= Html::a('Вернуться в список задач', Url::to(['/task/index']) ) ?></p>
