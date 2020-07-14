<?php

namespace spider\controllers;


use Yii;
use common\models\AdultVideoActress;
use common\models\AdultVideoActressDetail;
use common\models\AdultVideoActressWork;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use QL\QueryList;


class WwwokfhokcomController extends BaseController
{


    public function actionList()
    {

        ini_set('max_execution_time', 0);

        for ($i = 1; $i <= 36; $i++) {

            $url = $i === 1 ? 'http://www.okfhok.com/nvyouku' : "http://www.okfhok.com/nvyouku/index_$i.html";

            $rules = [
                'name' => ['.ny-info>h3', 'text'],
                'raw_name' => ['img', 'alt'],
                'avatar' => ['img', 'src'],
                'pinyin' => ['a', 'href']
            ];

            $range = '.nylist ul.clearfix li';

            $queryList = QueryList::get($url)
                ->range($range)
                ->rules($rules)
                ->query()
                ->getData();

            $rawDataList = $queryList->all();

            foreach ($rawDataList as $rawData) {
                $adultVideoActressModel = new AdultVideoActress();
                $adultVideoActressModel->name = $rawData['name'];
                $adultVideoActressModel->raw_name = $rawData['raw_name'];
                $adultVideoActressModel->pinyin = str_replace('/nvyouku/', '', str_replace('.html', '', $rawData['pinyin']));
                $adultVideoActressModel->avatar = base64_encode(file_get_contents('http://www.okfhok.com' . $rawData['avatar']));
                $adultVideoActressModel->save(false);
            }

        }

        echo '成功';

    }


    public function actionView()
    {

        ini_set('max_execution_time', 0);
        ini_set("user_agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Maxthon/4.4.8.1000 Chrome/30.0.1599.101 Safari/537.36");

        $scenario = Yii::$app->request->get('scenario');
        if ($scenario === 'multi') {

            $client = new Client(['base_uri' => 'http://spider.cms.com/wwwokfhokcom/view']);

            $promises = [];
            for ($i = 0; $i <= 99; $i++) {
                $promises[$i] = $client->getAsync("?dividend=$i");
            }

            $results = Promise\unwrap($promises);

            var_dump($results);

        } else {

            $dividend = (int)Yii::$app->request->get('dividend');

            $adultVideoActressModelList = AdultVideoActress::find()->all();

            foreach ($adultVideoActressModelList as $adultVideoActressModel) {

                if ($adultVideoActressModel->id % 100 === $dividend && !AdultVideoActressDetail::find()->where(['adult_video_actress_id' => $adultVideoActressModel->id])->one()) {

                    $url = "http://www.okfhok.com/nvyouku/{$adultVideoActressModel->pinyin}.html";

                    $queryList = QueryList::get($url);

                    $rawData = [
                        'describe' => $queryList->find('div.textinfo div.pos-r p')->text(),
                        'information' => $queryList
                            ->range('div.textinfo ul.pos-a li')
                            ->rules([
                                'value' => ['', 'text']
                            ])
                            ->query()
                            ->getData()
                            ->all(),
                    ];

                    $adultVideoActressDetailModel = new AdultVideoActressDetail();
                    $adultVideoActressDetailModel->adult_video_actress_id = $adultVideoActressModel->id;
                    $adultVideoActressDetailModel->describe = $rawData['describe'];
                    $information = [];
                    foreach ($rawData['information'] as $single) {
                        $single = explode('：', $single['value']);
                        $information[$single[0]] = $single[1];
                    }
                    $adultVideoActressDetailModel->information = $information;
                    $adultVideoActressDetailModel->save(false);

                    $rawDataList = $queryList
                        ->range('div.avlist-small ul.clearfix li')
                        ->rules([
                            'cover' => ['img', 'src'],
                            'designation' => ['h3', 'text'],
                            'publish_datetime' => ['p:eq(1)', 'text'],
                            'duration' => ['p:eq(0)', 'text'],
                        ])
                        ->query()
                        ->getData()
                        ->all();

                    foreach ($rawDataList as $rawData) {
                        $adultVideoActressWorkModel = new AdultVideoActressWork();
                        $adultVideoActressWorkModel->adult_video_actress_id = $adultVideoActressModel->id;
                        $adultVideoActressWorkModel->cover = base64_encode($this->curlFileGetContents('http://www.okfhok.com' . $rawData['cover']));
                        $adultVideoActressWorkModel->designation = $rawData['designation'];
                        $adultVideoActressWorkModel->publish_datetime = explode('：', $rawData['publish_datetime'])[1];
                        $adultVideoActressWorkModel->duration = (int)str_replace('分钟', '', explode('：', $rawData['duration'])[1]) * 60;
                        $adultVideoActressWorkModel->save(false);
                    }

                }

            }

            return '成功';

        }


    }


    public function actionWorkDownload()
    {

        ini_set('max_execution_time', 0);
        ini_set("user_agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Maxthon/4.4.8.1000 Chrome/30.0.1599.101 Safari/537.36");

        $scenario = Yii::$app->request->get('scenario');

        if ($scenario === 'multi') {

            $client = new Client(['base_uri' => 'http://spider.cms.com/wwwokfhokcom/work-download']);

            $promises = [];
            for ($i = 0; $i <= 99; $i++) {
                $promises[$i] = $client->getAsync("?dividend=$i");
            }

            $results = Promise\unwrap($promises);

            var_dump($results);

        } else {

            $dividend = (int)Yii::$app->request->get('dividend');

            $idList = [];
            for ($i = 1; $i <= 26431; $i++) {
                if ($i % 100 === $dividend) {
                    $idList[] = $i;
                }
            }

            $adultVideoActressWorkModelList = AdultVideoActressWork::find()
                ->where(['in', 'id', $idList])
                ->all();

            foreach ($adultVideoActressWorkModelList as $adultVideoActressWorkModel) {
                if ($adultVideoActressWorkModel->cover === '') {
                    $adultVideoActressWorkModel->cover = base64_encode($this->curlFileGetContents($adultVideoActressWorkModel->cover_url));
                    $adultVideoActressWorkModel->save(false);
                }
            }

            echo '123';

        }


    }


    public function actionWorkView()
    {

        ini_set('max_execution_time', 0);
        ini_set("user_agent", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Maxthon/4.4.8.1000 Chrome/30.0.1599.101 Safari/537.36");

        $scenario = Yii::$app->request->get('scenario');

        if ($scenario === 'multi') {

            $client = new Client(['base_uri' => 'http://spider.cms.com/wwwokfhokcom/work-view']);

            $promises = [];
            for ($i = 0; $i <= 99; $i++) {
                $promises[$i] = $client->getAsync("?dividend=$i");
            }

            $results = Promise\unwrap($promises);

            var_dump($results);

        } else {

            $dividend = (int)Yii::$app->request->get('dividend');

            $idList = [];
            for ($i = 1; $i <= 26431; $i++) {
                if ($i % 100 === $dividend) {
                    $idList[] = $i;
                }
            }

            $adultVideoActressWorkModelList = AdultVideoActressWork::find()
                ->where(['in', 'id', $idList])
                ->all();

            foreach ($adultVideoActressWorkModelList as $adultVideoActressWorkModel) {

                if ($adultVideoActressWorkModel->title === '') {

                    $url = "http://www.okfhok.com/fanhaoku/{$adultVideoActressWorkModel->designation}.html";
                    $queryList = QueryList::get($url);

                    $rawData = [
                        'title' => $queryList->find('div.content p:eq(0)')->text(),
                        'cover_url' => 'http://www.okfhok.com/' . $queryList->find('div.content img:eq(0)')->src,
                        'cover' => $adultVideoActressWorkModel->cover ? $adultVideoActressWorkModel->cover : base64_encode($this->curlFileGetContents('http://www.okfhok.com/' . $queryList->find('div.content img:eq(0)')->src)),
                        'information' => $queryList
                            ->range('div.content div.avinfo p')
                            ->rules([
                                'value' => ['', 'text']
                            ])
                            ->query()
                            ->getData()
                            ->all(),
                    ];

                    $information = [];
                    foreach ($rawData['information'] as $single) {
                        $single = explode('：', $single['value']);
                        $information[$single[0]] = $single[1];
                    }

                    $adultVideoActressWorkModel->title = explode('：', $rawData['title'])[1];
                    $adultVideoActressWorkModel->cover_url = $rawData['cover_url'];
                    $adultVideoActressWorkModel->cover = $rawData['cover'];
                    $adultVideoActressWorkModel->information = $information;
                    $adultVideoActressWorkModel->save(false);

                }

            }

            echo '123';

        }

    }


    protected function curlFileGetContents($imageUrl)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;

    }


}

