<?php

namespace backend\controllers;


use Yii;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnprocessableEntityHttpException;


class DevelopController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }


    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->identity->checkIsAdmin()) {
            return true;
        }

        throw new UnauthorizedHttpException('没有操作权限');

    }


    /**
     * phpinfo
     */
    public function actionPhpinfo()
    {

        echo phpinfo();
        exit();

    }


    /**
     * icon
     */
    public function actionIcon()
    {

        return $this->render('icon');

    }


}
