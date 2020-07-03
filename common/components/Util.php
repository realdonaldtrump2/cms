<?php

namespace common\components;

use Yii;
use yii\base\Component;
use Ramsey\Uuid\Uuid;
use common\models\User;


class Util extends Component
{


    /**
     * api检测登录
     *
     * @return array|bool|\yii\db\ActiveRecord|null
     */
    public function checkApiAuthorization()
    {

        if (isset(Yii::$app->request->headers['authorization']) && is_string(Yii::$app->request->headers['authorization'])) {

            $authorization = Yii::$app->request->headers['authorization'];
            $authorization = explode(' ', $authorization);
            if (isset($authorization[1])) {

                $userModel = User::find()
                    ->andFilterWhere(['=', 'token', $authorization[1]])
                    ->one();

                if (!$userModel) {
                    return false;
                }

                return $userModel;
            }

            return false;

        }

        return false;

    }


    /**
     * 检测时间区域
     *
     * @param $start
     * @param $end
     * @return bool
     */
    public function checkCurrentTimeRange($start, $end)
    {

        $currTime = time();
        $checkDayStr = date('Y-m-d ', $currTime);
        $timeBegin1 = strtotime($checkDayStr . $start . ':00:00');
        $timeEnd1 = strtotime($checkDayStr . ($end - 1) . ':59:59');
        return $currTime >= $timeBegin1 && $currTime <= $timeEnd1;

    }


    /**
     * 字符串替换
     *
     * @param $str
     * @param $len
     * @param string $suffix
     * @return string
     */
    public function cutString($str, $len = 9, $suffix = '...')
    {

        if (mb_strlen($str) > $len) {
            $str = mb_substr($str, 0, $len) . $suffix;
        }

        return $str;

    }


    /**
     * 生成uuid
     *
     * @return string
     * @throws \Exception
     */
    public function createUuid()
    {

        return Uuid::uuid4()->toString();

    }


    /**
     * 生成orderid
     *
     * @param $number
     * @return string
     */
    public function createOrderNumber($number)
    {

        return date('ymdHis') . str_pad($number, 6, '0', STR_PAD_LEFT) . $this->createRandom(4, true);

    }


    /**
     * 生成短信验证码
     *
     * @return string
     */
    public function createSmsCode()
    {

        return $this->createRandom(4, true);

    }


    /**
     * 生成随机字符串
     *
     * @param int $length
     * @param bool $number
     * @param bool $low
     * @return string
     */
    public function createRandom($length = 6, $number = false, $low = false)
    {

        $str = '';
        if ($number) {
            $range = '0123456789';
        } else if ($low) {
            $range = '0123456789abcdefghijklmnopqrstuvwxyz';
        } else {
            $range = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        }
        $max = strlen($range) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str .= $range[mt_rand(0, $max)];
        }
        return $str;

    }


    /**
     * 根据key 给二维数组分组
     *
     * @param $arrayList
     * @param $field
     * @return array
     */
    public function arrayGroupBy($arrayList, $field)
    {

        $newFieldList = array_unique(array_column($arrayList, $field));
        $newGroupArray = [];
        foreach ($newFieldList as $newField) {
            $newGroupArray[$newField] = [];
        }

        foreach ($newGroupArray as $k => $newGroup) {
            foreach ($arrayList as $key => $array) {
                if ($k == $array[$field]) {
                    $newGroupArray[$k][] = $array;
                }
            }
        }

        return $newGroupArray;

    }


    /**
     * 二维数组检测重复
     *
     * @param $dataList
     * @param $fieldNameList
     * @return bool
     */
    public function arrayCheckRepeat($dataList, $fieldNameList)
    {

        foreach ($fieldNameList as $fieldName) {
            $name = array_column($dataList, $fieldName);
            if (count($name) != count(array_unique($name))) {
                return true;
            }
        }
        return false;

    }


    /**
     * 二维数组根据字段进行排序
     *
     * @params array $array 需要排序的数组
     * @params string $field 排序的字段
     * @params string $sort 排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
     * @param $array
     * @param $field
     * @param string $sort
     * @return mixed
     */
    public function arraySequence($array, $field, $sort = 'SORT_ASC')
    {

        if (count($array) > 0) {
            $arrSort = [];
            foreach ($array as $uniqid => $row) {
                foreach ($row as $key => $value) {
                    $arrSort[$key][$uniqid] = $value;
                }
            }
            array_multisort($arrSort[$field], constant($sort), $array);
        }
        return $array;

    }


    /**
     * 获取某个月第一天/最后一天
     *
     * @param $date
     * @return array
     */
    public function monthFirstLast($date)
    {

        $firstDay = date('Y-m-01', strtotime($date));
        $lastDay = date('Y-m-d', strtotime("$firstDay +1 month -1 day"));
        return [$firstDay . ' 00:00:00', $lastDay . ' 23:59:59'];

    }


    /**
     * 将秒数转换为时间（年、天、小时、分、秒）
     *
     * @param $time
     * @return bool|string
     */
    public function secondToTime($time)
    {

        if (is_numeric($time)) {
            $value = array(
                'years' => 0, 'days' => 0, 'hours' => 0,
                'minutes' => 0, 'seconds' => 0,
            );
            if ($time >= 31556926) {
                $value['years'] = floor($time / 31556926);
                $time = ($time % 31556926);
            }
            if ($time >= 86400) {
                $value['days'] = floor($time / 86400);
                $time = ($time % 86400);
            }
            if ($time >= 3600) {
                $value['hours'] = floor($time / 3600);
                $time = ($time % 3600);
            }
            if ($time >= 60) {
                $value['minutes'] = floor($time / 60);
                $time = ($time % 60);
            }
            $value['seconds'] = floor($time);
            return $value['days'] . '天' . $value['hours'] . '小时' . $value['minutes'] . '分';
        }

        return false;

    }


    /**
     * array转xml
     *
     * @param $arr
     * @return string
     */
    public function arrayToXml($arr)
    {

        $xml = '<root>';
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= '<' . $key . '>' . self::arrayToXml($val) . '</' . $key . '>';
            } else {
                $xml .= '<' . $key . '>' . $val . '</' . $key . '>';
            }
        }
        $xml .= '</root>';
        return $xml;

    }


    /**
     * xml转array
     *
     * @param $xml
     * @return mixed
     */
    public function xmlToArray($xml)
    {

        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    }


    /**
     * 是否是微信客户端
     *
     * @return bool
     */
    public function isWechatClient()
    {

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * 是否是安卓客户端
     *
     * @return bool
     */
    public function isAndroidClient()
    {

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) {
            return true;
        } else {
            return false;
        }

    }


    /**
     * 是否是苹果客户端
     *
     * @return bool
     */
    public function isIosClient()
    {

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') === false) {
            return true;
        } else {
            return false;
        }

    }


}