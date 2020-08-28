<?php


return [
    'bootstrap' => ['devicedetect', 'log'],
    'timeZone' => 'PRC',
    'modules' => [
        'treemanager' => [
            'class' => 'kartik\tree\Module',
        ],
        'settings' => [
            'class' => 'pheme\settings\Module',
            'sourceLanguage' => 'zh-CN'
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=cms',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8mb4',
            'emulatePrepare' => true,
            'schemaCacheDuration' => 3600,
            'schemaCache' => 'cache',
        ],
        'assetManager' => [
            'bundles' => [
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.163.com',
                'username' => 'jzbx55@163.com',
                'password' => '123456abc',
                'port' => '25',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => [
                    'jzbx55@163.com' => '服务器管理员',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                // 不要使用
                // [
                //     'class' => 'yii\log\SyslogTarget',
                //      'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                // ],
                // 记录sql语句
                [
                    'class' => 'common\target\SqlTarget',
                    'levels' => ['info'],
                    'categories' => [
                        'yii\db\Command::query',
                        'yii\db\Command::execute',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'], // 普通日志
                    'maxFileSize' => 10240,
                    'maxLogFiles' => 10,
                    'logFile' => '@app/runtime/logs/common_' . date('Ymd') . '.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['invalidate'], // 记录结算
                    'maxFileSize' => 10240,
                    'maxLogFiles' => 10,
                    'logFile' => '@app/logs/invalidate_' . date('Ymd') . '.log',
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['invalidate'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['third-pay-callback'], // 记录第三方回调
                    'maxFileSize' => 10240,
                    'maxLogFiles' => 10,
                    'logFile' => '@app/logs/third_pay_callback_' . date('Ymd') . '.log',
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['third-pay-callback'],
                ],
                // [
                //     'class' => 'yii\log\EmailTarget',
                //     'mailer' => 'mailer',
                //     'levels' => ['error', 'warning'],
                //     'categories' => ['third-pay-callback'],
                //     'message' => [
                //         'from' => ['jzbx55@163.com'],
                //         'to' => ['jzbx55@163.com'],
                //         'subject' => 'Log message',
                //     ],
                // ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['transaction'], // 记录事务
                    'maxFileSize' => 10240,
                    'maxLogFiles' => 10,
                    'logFile' => '@app/logs/transaction_' . date('Ymd') . '.log',
                ],
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning', 'info', 'trace', 'profile'],
                    'categories' => ['transaction'],
                ],
            ],
        ],
        'devicedetect' => [
            'class' => 'alexandernst\devicedetect\DeviceDetect',
        ],
        'settings' => [
            'class' => 'pheme\settings\components\Settings'
        ],
        'util' => [
            'class' => 'common\components\Util',
        ],
        'formatField' => [
            'class' => 'common\components\FormatField',
        ],
        'verifyField' => [
            'class' => 'common\components\VerifyField',
        ],
        'pdf' => [
            'class' => 'common\components\Pdf',
        ],
        'excel' => [
            'class' => 'common\components\Excel',
        ],
    ],
];
