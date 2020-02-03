<?php


use yii\web\View;
/**
 * @var View $this
 * @var array $events
 */
?>

<?= edofre\fullcalendar\Fullcalendar::widget([
    'options' => [
        'id' => 'calendar',
        'language' => 'ru',
    ],
    'clientOptions' => [
        'weekNumbers' => true,
        'selectable' => true,
        'defaultView' => 'month',
    ],
    'events' => $events,
]);
?>