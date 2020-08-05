<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use common\models\ChineseProverb;
use common\models\ChineseWord;
use common\models\ChineseIdiom;
use common\models\ChineseCharacter;
use common\models\ChineseAntonym;
use common\models\ChineseSynonym;
use common\models\ChineseNegative;
use common\models\ChineseCharacterStroke;
use common\models\InformationPositionCategory;
use common\models\InformationSensitivityWord;
use DfaFilter\SensitiveHelper;


class TestController extends BaseController
{


    public function actionIndex()
    {


    }


    public function actionHistory()
    {

//        $file = fopen("http://backend.cms.com/json/dict_synonym.txt", "r");
//        $array = [];
//        $i = 0;
//        while (!feof($file)) {
//            $array[$i] = str_replace(["\r\n", "\r", "\n"], '', trim(fgets($file), ' '));
//            $i++;
//        }
//        fclose($file);
//        dd($array);

//        foreach ($array as $single) {
//
//            $single2 = explode("\t", $single);
//
//            if ($single2[0] !== '□') {
//                $ChineseCharacterStroke = new ChineseCharacterStroke();
//                $ChineseCharacterStroke->scenario = 'create';
//                $ChineseCharacterStroke->word = $single2[0];
//                $ChineseCharacterStroke->stroke = $single2[1];
//                $ChineseCharacterStroke->save();
//            }
//
//        }

//        foreach ($array as $single) {
//            $informationSensitivityWord = new InformationSensitivityWord();
//            $informationSensitivityWord->scenario = 'create';
//            $informationSensitivityWord->category = 'website';
//            $informationSensitivityWord->word = $single;
//            $informationSensitivityWord->save();
//        }

//        foreach ($array as $single) {
//            $informationPositionCategory = new InformationPositionCategory();
//            $informationPositionCategory->scenario = 'create';
//            $informationPositionCategory->title = $single;
//            $informationPositionCategory->save();
//        }

//        foreach ($array as $single) {
//            $single = explode("\t", $single);
//            $chineseNegative = new ChineseNegative();
//            $chineseNegative->scenario = 'create';
//            $chineseNegative->word = $single[0];
//            $chineseNegative->save();
//        }

//        foreach ($array as $single) {
//            $chineseSynonymModel = new ChineseSynonym();
//            $chineseSynonymModel->scenario = 'create';
//            $chineseSynonymModel->keyword_container = ['keyword' => explode(' ', $single)];
//            $chineseSynonymModel->save();
//        }

//        $json = file_get_contents('http://backend.cms.com/json/word.json');
//        $array = json_decode($json, true);
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

//        foreach ($array as $single) {
//            $chineseCharacterModel = new ChineseCharacter();
//            $chineseCharacterModel->scenario = 'create';
//            $chineseCharacterModel->word = $single['word'];
//            $chineseCharacterModel->oldword = $single['oldword'];
//            $chineseCharacterModel->strokes = $single['strokes'];
//            $chineseCharacterModel->pinyin = $single['pinyin'];
//            $chineseCharacterModel->radicals = $single['radicals'];
//            $chineseCharacterModel->explain = $single['explanation'];
//            $chineseCharacterModel->more_explain = $single['more'];
//            $chineseCharacterModel->save();
//        }

    }


}