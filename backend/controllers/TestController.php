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
        while ($reader->read("type")) {
            var_dump($reader->value());
        }
        $reader->close();

//        $reader->close();

//        $reader = new pcrov\JsonReader\JsonReader();
//        $reader->open("data.json");
//        while ($reader->read()) {
//            $name = $reader->name();
//            if ($name !== null) {
//                echo "$name: {$reader->value()}\n";
//            }
//        }
//        $reader->close();

    }


}