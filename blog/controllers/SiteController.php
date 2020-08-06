<?php

namespace blog\controllers;

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
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['list'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['about'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['contact'],
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
     * 维护
     */
    public function actionOffline()
    {

        return $this->render('offline');

    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');

    }


    /**
     * @return mixed
     */
    public function actionList()
    {

        return $this->render('list');

    }


    /**
     * @return mixed
     */
    public function actionView()
    {

        return $this->render('view');

    }


    /**
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');

    }


    /**
     * @return mixed
     */
    public function actionContact()
    {

        return $this->render('contact');

    }


}
