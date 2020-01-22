<?php
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use common\models\Task;
use yii\web\View;
use yii\helpers\Url;

/**
 * @var  View $this
 * @var  Task $model
 * @var $templates array
 */

$this->title = 'Редактирование задачи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'редактирование';

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
    'templates' => $templates ?: [],
]) ?>