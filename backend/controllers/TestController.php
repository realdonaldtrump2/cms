<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use common\models\ChineseProverb;
use common\models\ChineseWord;
use common\models\ChineseIdiom;
use common\models\ChineseCharacter;


class TestController extends BaseController
{


    public function actionIndex()
    {

        $json = file_get_contents('http://backend.cms.com/json/word.json');
        $array = json_decode($json, true);
//        dd($array);

//        foreach ($array as $single) {
//            $chineseProverbModel = new ChineseProverb();
//            $chineseProverbModel->scenario = 'create';
//            $chineseProverbModel->riddle = $single['riddle'];
//            $chineseProverbModel->answer = $single['answer'];
//            $chineseProverbModel->save();
//        }

//        foreach ($array as $single) {
//            $chineseWordModel = new ChineseWord();
//            $chineseWordModel->scenario = 'create';
//            $chineseWordModel->word = $single['ci'];
//            $chineseWordModel->explain = $single['explanation'];
//            $chineseWordModel->save();
//        }

//        foreach ($array as $single) {
//            $chineseIdiomModel = new ChineseIdiom();
//            $chineseIdiomModel->scenario = 'create';
//            $chineseIdiomModel->word = $single['word'];
//            $chineseIdiomModel->pinyin = $single['pinyin'];
//            $chineseIdiomModel->abbreviation = $single['abbreviation'];
//            $chineseIdiomModel->derivation = $single['derivation'];
//            $chineseIdiomModel->explain = $single['explanation'];
//            $chineseIdiomModel->example = $single['example'];
//            $chineseIdiomModel->save();
//        }

        foreach ($array as $single) {
            $chineseCharacterModel = new ChineseCharacter();
            $chineseCharacterModel->scenario = 'create';
            $chineseCharacterModel->word = $single['word'];
            $chineseCharacterModel->oldword = $single['oldword'];
            $chineseCharacterModel->strokes = $single['strokes'];
            $chineseCharacterModel->pinyin = $single['pinyin'];
            $chineseCharacterModel->radicals = $single['radicals'];
            $chineseCharacterModel->explain = $single['explanation'];
            $chineseCharacterModel->more_explain = $single['more'];
            $chineseCharacterModel->save();
        }

    }


}