<?php

namespace spider\controllers;


use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use QL\QueryList;
use common\models\SoftwareCategory;


class WwwZhanshaoyiComController extends BaseController
{


    public function actionCategory()
    {

        ini_set('max_execution_time', 0);

        $url = 'http://www.zhanshaoyi.com/rjxz.html';

        $rules = [
            'name' => ['', 'text'],
        ];

        $range = 'div.entry-content h2';

        $queryList = QueryList::get($url)
            ->range($range)
            ->rules($rules)
            ->query()
            ->getData();

        $rawDataList = $queryList->all();

        dd($rawDataList);

//        foreach ($rawDataList as $rawData) {
//            $softwareCategory = new SoftwareCategory();
//            $softwareCategory->title = $rawData['name'];
//            $softwareCategory->save(false);
//        }

    }


    public function actionSoftware()
    {

        ini_set('max_execution_time', 0);

        $url = 'http://www.zhanshaoyi.com/rjxz.html';

        $rules = [
            'title' => ['strong', 'text'],
            'software' => ['', 'html'],
        ];

        $range = 'div.entry-content p';

        $queryList = QueryList::get($url)
            ->range($range)
            ->rules($rules)
            ->query()
            ->getData();

        $rawDataList = $queryList->all();

        dd($rawDataList);

    }


}
