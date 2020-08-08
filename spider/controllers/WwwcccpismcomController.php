<?php

namespace spider\controllers;

use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use QL\QueryList;


class WwwcccpismcomController extends BaseController
{


    public function actionImage()
    {

        ini_set('max_execution_time', 0);

        for ($i = 133; $i <= 240; $i++) {

            $output = "xch{$i}.jpg";
            $url = "http://www.cccpism.com/soviet/huahemedel/images/xch{$i}.jpg";
            file_put_contents($output, file_get_contents($url));

        }

    }


}