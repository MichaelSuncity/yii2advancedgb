<?php


namespace console\controllers;


use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws \Exception
     *
     *
     * php yii rbac/init
     *
     */
    public function actionInit()
    {
        //аналогично выполнению в терминале 'php yii migrate --migrationPath=@yii/rbac/migrations'
        \Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations']);

        /**
         * создание ролей пользователей
         * юзер
         * менеджер
         * админ
         */

        $auth = \Yii::$app->authManager;

        $roleUser = $auth->createRole('user');
        $roleUser->description = 'Обычный пользователь сайта';
        $auth->add($roleUser);

        $roleManager = $auth->createRole('manager');
        $roleManager->description = 'Менеджер сайта';
        $auth->add($roleManager);
        $auth->addChild($roleManager, $roleUser); // менеджер наследует права пользователя

        $roleAdmin = $auth->createRole('admin');
        $roleAdmin->description = 'Администратор сайта';
        $auth->add($roleAdmin);
        $auth->addChild($roleAdmin, $roleManager);// администратор наследует менеджера и пользователя

        /**
         *
         * Установка ролей на пользователей
         *
         */

        $auth->assign($roleAdmin,1);
        $auth->assign($roleManager, 2);
        $auth->assign($roleUser,3);
    }
}