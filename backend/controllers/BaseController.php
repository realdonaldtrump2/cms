<?php

namespace backend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

use common\models\UserOperateLog;


class BaseController extends Controller
{

    public function init()
    {
        parent::init();
    }


    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        try {
            UserOperateLog::record();
        } catch (\Exception $e) {
        }

        if (Yii::$app->request->get('layout') === 'function') {
            $this->layout = 'function';
        }

        return true;

    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ]
        ];
    }


}
