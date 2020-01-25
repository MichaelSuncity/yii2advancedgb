<?php


namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
/**
* @property-read  User $author
*/

class MailerController extends Controller
{
    public $author;

    public function options($action)
    {
        return ['author'];
    }

    public function optionAliases()
    {
        return [
           'a' => 'author',
        ];
    }

    // для отправки прописать php yii mailer/send -a=1...
    public function actionSend()
    {
       if(is_numeric($this->author)){
           $user = User::findOne(['id' => $this->author]);
           echo "Hello {$user->username}";

           Yii::$app->mailer->compose()
               ->setFrom('tests.pismaroff@mail.ru')
               ->setTo('ludmila.pismarova@yandex.ru')
               ->setSubject('Тестовая отправка письма из консоли Yii')
               ->setTextBody("Здравствуйте {$user->username}. Вам пришло тестовое сообщение из консоли Yii.")
               ->send();
       }
    }
}