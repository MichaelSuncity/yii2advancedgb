<?php

namespace backend\modules\admincache\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use Yii;

/**
 * Default controller for the `admincache` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFlush()
    {
        return  Yii::$app->cache->flush() && $this->redirect(Url::to('http://back.yii2advanced.gb/'));
    }
}
