<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [

        'gridview' =>  [
            'class' => '\kartik\grid\Module',
    ]],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\Users',
            'enableAutoLogin' => false,
        ],
        'company' => [
           'class' => 'common\components\CompanyComponent',
        ],
        'role' => [
           'class' => 'common\components\RoleComponent',
        ],
        'mailer' => [
            'class' => "yii\swiftmailer\Mailer",
            'useFileTransport' =>false,
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
        'urlManager' => [
             'class' => 'yii\web\UrlManager',
             // Disable index.php
             'showScriptName' => false,
             // Disable r= routes
             'enablePrettyUrl' => true,
             'rules' => array(
                     '<controller:\w+>/<id:\d+>' => '<controller>/view',
                     '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                     '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
             ),
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
