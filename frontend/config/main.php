<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'frontend',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    //维护显示页面
    //'catchAll'=>['site/offline'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend-token',
            'cookieValidationKey' => 'BuwXyHFmz4mseTD3xkg1hZSusoz4oqvx',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend-token', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '_cookie-frontend-token',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            //路由美化
            'enablePrettyUrl' => true,
            //rewrite模式
            'showScriptName' => false,
            //强制路由
            'enableStrictParsing' => false,
            //伪静态
            'suffix' => '',
            'rules' => [
                '/' => 'site/index',
                'error' => 'site/error',
                'offline' => 'site/offline',
            ]
        ]
    ],
    'params' => $params,
];

//关闭底部追踪
if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
