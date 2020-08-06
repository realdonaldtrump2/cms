<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'blog',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'blog\controllers',
    'bootstrap' => ['log'],
    //维护显示页面
    //'catchAll'=>['site/offline'],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-blog-token',
            'cookieValidationKey' => 'BuwXyHFmz4mseTD3xkg1hZasotz4oqvx',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-blog-token', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the blog
            'name' => '_cookie-blog-token',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            //路由美化
            'enablePrettyUrl' => true,
            //rewrite模式
            'showScriptName' => true,
            //强制路由
            'enableStrictParsing' => true,
            //伪静态
            'suffix' => '',
            'rules' => [
                '/' => 'site/index',
                'error' => 'site/error',
                'offline' => 'site/offline',
                'list' => 'site/list',
                'view' => 'site/view',
                'about' => 'site/about',
                'contact' => 'site/contact',
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
