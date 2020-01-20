<?php

use yii\helpers\Html;

$this->title = 'Chat';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div id="chat" style="min-height: 100px; border-color: #1c7430; border: 2px;"></div>
<div id="response" style="color:#D00"></div>
<div class="row">
    <div class="col-lg-9">
        <?= Html::textInput('message', '', ['id' => 'message', 'class' => 'form-control'])?>
    </div>

    <div class="col-lg-3">
        <?= Html::button('Отправить', ['id' => 'send', 'class' => 'btn btn-primary'])?>
    </div>
</div>
<?php if (Yii::$app->user->isGuest) {
    $username = 'guest' . time();
} else {
    $username = Yii::$app->user->identity->username;
} ?>
<?= Html::hiddenInput('username', $username, ['class' => 'js-username']) ?>
