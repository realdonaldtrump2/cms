<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use GuzzleHttp\Client;


class Oauth2Controller extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['callback'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ]
            ]
        ];
    }


    public function actionCallback()
    {

        $scenario = Yii::$app->request->get('scenario');
        if ($scenario === 'github') {

            $code = Yii::$app->request->get('code');

            $client = new Client();
            $response = $client->request('POST', 'https://github.com/login/oauth/access_token', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'client_id' => '2498a0e9c56f9df53a20',
                    'client_secret' => '913d7341dafc674bec981eebf558cb83d0b4fff6',
                    'code' => $code,
                ],
                'query' => [
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                exit();
            }

            $responseParam = json_decode($response->getBody()->getContents(), true); //获取响应体，对象
            $access_token = $responseParam['access_token'];

            $client = new Client();
            $response = $client->request('GET', 'https://api.github.com/user', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'token ' . $access_token,
                ],
                'query' => [
                ]
            ]);

            if ($response->getStatusCode() !== 200) {
                exit();
            }

            $responseParam = json_decode($response->getBody()->getContents(), true); //获取响应体，对象

            // 查询github_id如果不存在 session存储github_id 添加一行数据 跳转到绑定页面 进行绑定

            // 如果github_id存在 并且user_id等于0 session存储github_id 添加一行数据 跳转到绑定页面 进行绑定

            // 如果github_id存在 并且user_id不等于1

//            dd($responseParam);

        }


    }


}
