<?php

use yii\helpers\Html;

?>
<h1>Очистка кэша</h1>
<p><?= Html::a('Flush Cash', ['flush'], [
    'class' => 'btn btn-success',
    'data' => [
        'confirm' => 'Are you sure you want to flush all cash?',
        'method' => 'post',
    ],
]);?></p>

