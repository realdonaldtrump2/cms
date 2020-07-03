<?php


$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);


$config = [
    'id' => 'api',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'spider' => [
            'class' => 'api\modules\spider\Module',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => 'json',
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {

                Yii::$app->response->headers->remove('location');

                Yii::$app->response->headers->remove('Location');

                $response = $event->sender;

                if (!isset(Yii::$app->request->headers['abcd'])) {

                    $module = Yii::$app->controller->module->id;
                    $controller = Yii::$app->controller->id;
                    $action = Yii::$app->controller->action->id;

                    if ($module === 'purchaser' && $controller === 'shop-goods' && $action === 'index') {
                        $shopModel = Yii::$app->util->checkApiAuthorization()->userShop->shop;
                        if ($shopModel->is_delete !== 0) {
                            foreach ($response->data['items'] as $key => $single) {
                                $response->data['items'][$key]['price'] = 999999;
                                $response->data['items'][$key]['recharge_member_price'] = 999999;
                            }
                        }
                    }

                    if ($response->statusCode === 200) {

                        if (!isset($response->data['error'])) {
                            $response->data = [
                                'error' => 0,
                                'message' => '成功',
                                'data' => $response->data
                            ];
                        }

                        if (is_array($response->data['message'])) {
                            $response->data['message'] = current($response->data['message'])[0];
                        }

                    } else if ($response->statusCode === 201) {

                        $response->data = [
                            'error' => 0,
                            'message' => '成功',
                            'data' => $response->data
                        ];

                    } else {

                        if (isset($response->data['message']) && is_array($response->data['message'])) {
                            $newMessage = $response->data['message'];
                            $response->data['message'] = current(current($newMessage));
                        }

                        if ($response->statusCode !== 200 && $response->statusCode < 500) {
                            $response->data['error'] = $response->statusCode;
                            if ($response->statusCode === 401) {
                                $response->data['message'] = '没有登录';
                            } else if ($response->statusCode === 403) {
                                $response->data['message'] = '店铺已下线，有问题请联系客服';
                            } else if ($response->statusCode === 404) {
                                $response->data['message'] = '不存在';
                            } else if ($response->statusCode === 422) {
                                if (isset($response->data['message'])) {
                                    if (is_array($response->data['message'])) {
                                        $response->data = [
                                            'message' => $response->data['message'][0]['message']
                                        ];
                                    }
                                } else {
                                    $response->data = [
                                        'message' => $response->data[0]['message'] ? $response->data[0]['message'] : '参数错误'
                                    ];
                                }
                            } else if ($response->statusCode === 429) {
                                $response->data['message'] = '访问过于频繁';
                            } else if ($response->statusCode === 500) {
                                $response->data['message'] = '服务器异常';
                            }
                            $response->data['message'] = isset($response->data['message']) ? $response->data['message'] : '';
                            $response->statusCode = 200;
                        }

                    }

                    $response->statusCode = 200;

                    if (isset($response->data['code'])) {
                        unset($response->data['code']);
                    }

                    if (isset($response->data['status'])) {
                        unset($response->data['status']);
                    }

                    if (isset($response->data['type'])) {
                        unset($response->data['type']);
                    }

                    if (isset($response->data['name'])) {
                        unset($response->data['name']);
                    }

                }
            }
        ],
        'urlManager' => [
            //路由美化
            'enablePrettyUrl' => true,
            //rewrite模式
            'showScriptName' => false,
            //强制路由
            'enableStrictParsing' => true,
            // 伪静态
            'suffix' => '',
            'rules' => [

                'spider/default/index' => 'spider/default/index',

            ]
        ],
    ],
    'params' => $params,
];

return $config;
