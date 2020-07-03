<?php

namespace spider\controllers;


use Yii;
use yii\filters\AccessControl;


class SiteController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
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

        echo 'spider';

    }


}
