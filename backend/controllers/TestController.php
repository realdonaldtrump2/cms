<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;


class TestController extends BaseController
{


    public function actionIndex()
    {

        Yii::$app->pdf->resumeGenerate();

    }


}