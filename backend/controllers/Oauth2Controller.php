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

            // 查询github_id如果不存在 session存储github_id 添加一行数据 跳转到绑定页面 进行绑定

            // 如果github_id存在 并且user_id等于0 session存储github_id 添加一行数据 跳转到绑定页面 进行绑定

            // 如果github_id存在 并且user_id不等于1

//            dd($responseParam);

        }


    }


}
