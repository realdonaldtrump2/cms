<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use pcrov\JsonReader\JsonReader;
use common\models\InformationQuestionAndAnswer;


class TestController extends BaseController
{


    public function actionIndex()
    {

        ini_set('max_execution_time', 0);

        $file = fopen("http://backend.cms.com/zhidao_qa.json", "r") or exit("Unable to open file!");
        while (!feof($file)) {
            $array = json_decode(fgets($file), true);
            $informationQuestionAndAnswerModel = new InformationQuestionAndAnswer();
            $informationQuestionAndAnswerModel->scenario = 'create';
            $informationQuestionAndAnswerModel->old_id = $array['_id']['$oid'];
            $informationQuestionAndAnswerModel->url = $array['url'];
            $informationQuestionAndAnswerModel->answer = $array['answers'];
            $informationQuestionAndAnswerModel->question = $array['question'];
            $informationQuestionAndAnswerModel->tag = $array['tags'];
            $informationQuestionAndAnswerModel->save(false);
        }
        fclose($file);
        echo '成功';

//        $reader = new JsonReader();
//        $reader->open('http://backend.cms.com/demo.json');
//        $reader->read(); // Step to the first object.
//        do {
//            print_r($reader->value()); // Do your thing.
//        } while ($reader->next()); // Read each sibling.
//        $reader->close();

    }


}