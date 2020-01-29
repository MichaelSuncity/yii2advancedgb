<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Project;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'priority_id')->textInput()->dropDownList(\common\models\Priority::getProjectPriorities())?>
    <?= $form->field($model, 'status')->dropDownList(Project::getStatusName()) ?>
    <?= $form->field($model, 'is_parent')->checkbox() ?>
    <?= $form->field($model, 'parent_project_id')->textInput()->dropDownList(\common\models\Project::getParentProjectNames(), ['prompt'=>'Значение не выбрано']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<p><?= Html::a('Вернуться в список проектов', Url::to(['/project/index']) ) ?></p>
