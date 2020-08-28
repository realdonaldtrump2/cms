<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use pcrov\JsonReader\JsonReader;


class TestController extends BaseController
{


    public function actionIndex()
    {

        $reader = new JsonReader();
        $reader->open("http://backend.cms.com/zhidao_qa.json");
        while ($reader->read("_id")) {
            var_dump($reader->value());
            exit();
        }

    }


}