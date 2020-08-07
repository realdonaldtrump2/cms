<?php

namespace spider\controllers;


use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use QL\QueryList;
use common\models\SoftwareCategory;
use common\models\Software;


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

        $finalDataList = [];
        foreach ($rawDataList as $key => $single) {
            if ($key >= 2 && $key <= 418) {
                if ($single['software'] !== '持续更新中……') {
                    $finalDataList[] = $single;
                }
            }
        }

        $newSingle = [];
        foreach ($finalDataList as $key => $single) {
            if ($single['title'] !== '') {
                $newSingle[] = ['title' => $single['title'], 'detail' => []];
            } else {
                $count = count($newSingle);
                $newSingle[$count - 1]['detail'][] = $single['software'];
            }
        }

//        foreach ($newSingle as $single) {
//            $software = new Software();
//            $software->title = $single['title'];
//            $software->detail = $single['detail'];
//            $software->save(false);
//        }

    }


}
