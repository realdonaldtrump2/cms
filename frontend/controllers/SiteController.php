<?php

namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;


class SiteController extends BaseController
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
                        'actions' => ['offline'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                ],
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');

    }


    /**
     * 维护
     */
    public function actionOffline()
    {

        return $this->render('offline');

    }


}
