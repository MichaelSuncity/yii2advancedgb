<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'calendar',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity', 'httpOnly' => true, 'domain' => '.yii2advanced.gb'],
        ],
        'session' => [
            'name' => 'advanced',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'controller' => 'api/task',
                    'class' => \yii\rest\UrlRule::class,
                    'extraPatterns' => [
                        //'METHOD action' => 'actionFunction',
                        'POST random/<count>' => 'random',
                        'GET data-provider/<limit>' => 'data-provider',
                        'GET auth' => 'auth',
                    ],
                ],
                [
                    'controller' => 'api/user',
                    'class' => \yii\rest\UrlRule::class,
                    'extraPatterns' => [
                    ],
                ],
            ],
        ],
    ],
    'modules' => [
        'api' => [
            'class' => \frontend\modules\api\Module::class
        ],
        'account' => [
            'class' => \frontend\modules\account\Module::class
        ],
    ],
    'params' => $params,
];
