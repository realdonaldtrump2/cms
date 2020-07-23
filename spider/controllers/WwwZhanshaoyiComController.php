<?php

namespace spider\controllers;


use Yii;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use QL\QueryList;


class WwwZhanshaoyiComController extends BaseController
{


    public function actionCategory()
    {

        ini_set('max_execution_time', 0);

        $url = 'http://www.zhanshaoyi.com/rjxz.html';

        $rules = [
            'name' => ['strong', 'text'],
        ];

        $range = 'div.entry-content h2';

        $queryList = QueryList::get($url)
            ->range($range)
            ->rules($rules)
            ->query()
            ->getData();

        $rawDataList = $queryList->all();

        dd($rawDataList);

    }


}
