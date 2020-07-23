<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'backend',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    // 关掉开发模式
    // 维护显示页面   https://www.yiichina.com/topic/5898  关掉开发模式
    // 'catchAll'=>['site/offline'],
    // 'bootstrap' => ['log'],
    'bootstrap' => ['logreader'],
    'modules' => [
        'logreader' => [
            'class' => 'zhuravljov\yii\logreader\Module',
            'aliases' => [
                'Frontend Errors' => '@frontend/runtime/logs/app.log',
                'Backend Errors' => '@backend/runtime/logs/app.log',
                'Console Errors' => '@console/runtime/logs/app.log',
                'Open Errors' => '@open/runtime/logs/app.log',
                'Api Errors' => '@api/runtime/logs/app.log',
            ],
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module',
        ],
    ],
    'on beforeRequest' => function ($event) {
        // \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['common\models\UserOperateLog', 'save']);
    },
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'cookieValidationKey' => '2EemE6-mD955ejVMPr8IhDrvRDGU_3nL',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend-token', 'httpOnly' => true],
            'on afterLogin' => function ($event) {
                \common\models\UserAuthenticationLog::record(1);
            },
            'on beforeLogout' => function ($event) {
                \common\models\UserAuthenticationLog::record(2);
            },
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => '@backend/web/vendor/jquery/dist',
                    'js' => ['jquery.js']
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@backend/web/vendor/bootstrap/dist',
                    'css' => ['css/bootstrap.css'],
                    'js' => ['js/bootstrap.js']
                ],
            ],
        ],
        'authManager' => [
            'class' => 'common\rbac\DbManager',
            'itemTable' => 'rbac_auth_item',    // 授权条目
            'itemChildTable' => 'rbac_auth_item_child',     // 授权条目的层次关系
            'assignmentTable' => 'rbac_auth_assignment',    // 授权条目对用户的指派情况
            'ruleTable' => 'rbac_auth_rule',    // 规则
        ],
        'urlManager' => [
            // 路由美化
            'enablePrettyUrl' => true,
            // rewrite模式
            'showScriptName' => false,
            // 强制路由
            'enableStrictParsing' => false,
            // 伪静态
            'suffix' => '',
            'rules' => [

                // 功能页面
                '/' => 'site/index',    // 主页
                'captcha' => 'site/captcha',    // 验证码
                'offline' => 'site/offline',    //  维护
                // 'register' => 'site/register',    //  注册
                'login' => 'site/login',    //  登录
                'logout' => 'site/logout',     //  退出
                'modify-info' => 'site/modify-info',   //  修改密码
                // 'reset-info' => 'site/reset-info',    //找回密码
                'test' => 'site/test',    //  测试

                // rbac管理
                'role-index' => 'rbac/role-index',
                'role-create' => 'rbac/role-create',
                'role-update' => 'rbac/role-update',
                'role-view' => 'rbac/role-view',
                'role-permission' => 'rbac/role-permission',
                'permission-index' => 'rbac/permission-index',
                'permission-create' => 'rbac/permission-create',
                'permission-update' => 'rbac/permission-update',
                'permission-scan' => 'rbac/permission-scan',

                // 上传管理
                'upload-image-base64' => 'upload/image-base64',     // 上传图片 base64
                'upload-image-file' => 'upload/image-file',     // 上传图片文件
                'upload-file' => 'upload/file',    // 上传文件
                'upload-base64' => 'upload/base64',     //  上传base64

            ],
        ],
    ],
    'params' => $params,
];

//关闭底部追踪
if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*']
    ];
}

return $config;
