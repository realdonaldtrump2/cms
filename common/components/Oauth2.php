<?php

namespace common\components;


use Yii;
use yii\base\Component;
use GuzzleHttp\Client;


class Oauth2 extends Component
{


    public function github($code)
    {

        $client = new Client();
        $response = $client->request('POST', 'https://github.com/login/oauth/access_token', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'client_id' => '2498a0e9c56f9df53a20',
                'client_secret' => '913d7341dafc674bec981eebf558cb83d0b4fff6',
                'code' => $code,
            ],
            'query' => [
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            exit();
        }

        $responseParam = json_decode($response->getBody()->getContents(), true); //获取响应体，对象
        $access_token = $responseParam['access_token'];

        $client = new Client();
        $response = $client->request('GET', 'https://api.github.com/user', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'token ' . $access_token,
            ],
            'query' => [
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            exit();
        }

        $responseParam = json_decode($response->getBody()->getContents(), true); //获取响应体，对象
        dd($responseParam);

    }


}