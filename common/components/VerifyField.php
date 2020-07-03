<?php

namespace common\components;

use Yii;
use yii\base\Component;


class VerifyField extends Component
{


    /**
     * 验证身份证
     *
     * @param $userName
     * @param $identifyNum
     * @return bool
     */
    public function id($userName, $identifyNum)
    {

        return true;

        if ($this->is18IdCard($identifyNum) || $this->is15IdCard($identifyNum)) {
        } else {
            return false;
        }

        if (empty($userName) || empty($identifyNum)) {
            return false;
        }

        $appCode = Yii::$app->params['aliIdVerify']['appCode'];
        $userId = Yii::$app->params['aliIdVerify']['userId'];
        $verifyKey = Yii::$app->params['aliIdVerify']['verifyKey'];

        $host = 'https://safrvcert.market.alicloudapi.com';
        $path = '/safrv_2meta_id_name/';
        $query = "__userId={$userId}&customerID=customerID&identifyNum={$identifyNum}&userName={$userName}&verifyKey={$verifyKey}";
        $url = $host . $path . '?' . $query;
        $json = $this->curlRequest($host, $url, $appCode, 'GET');
        $return = json_decode($json, true);
        if ($return['code'] != 200) {
            return false;
        }
        return true;

    }


    /**
     * 验证身份证号码格式是否正确
     * 仅支持一代身份证
     *
     * @param $idCard
     * @return bool
     */
    public function is15IdCard($idCard)
    {

        // 只能是15位
        return !(strlen($idCard) !== 15);

    }


    /**
     * 验证身份证号码格式是否正确
     * 仅支持二代身份证
     *
     * @param string $idCard 身份证号码
     * @return boolean
     * @author chiopin
     */
    public function is18IdCard($idCard)
    {

        // 只能是18位
        if (strlen($idCard) !== 18) {
            return false;
        }

        $vCity = array(
            '11', '12', '13', '14', '15', '21', '22',
            '23', '31', '32', '33', '34', '35', '36',
            '37', '41', '42', '43', '44', '45', '46',
            '50', '51', '52', '53', '54', '61', '62',
            '63', '64', '65', '71', '81', '82', '91'
        );

        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $idCard)) return false;

        if (!in_array(substr($idCard, 0, 2), $vCity)) return false;

        // 取出本体码
        $idCard_base = substr($idCard, 0, 17);

        // 取出校验码
        $verify_code = substr($idCard, 17, 1);

        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        // 根据前17位计算校验码
        $total = 0;
        for ($i = 0; $i < 17; $i++) {
            $total += substr($idCard_base, $i, 1) * $factor[$i];
        }

        // 取模
        $mod = $total % 11;

        // 比较校验码
        if ($verify_code == $verify_code_list[$mod]) {
            return true;
        }

        return false;

    }


    /**
     * curl请求接口
     *
     * @param $host
     * @param $url
     * @param $appCode
     * @param $method
     * @return bool|string
     */
    public function curlRequest($host, $url, $appCode, $method)
    {
        $headers = [];
        $headers[] = 'Authorization:APPCODE ' . $appCode;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos('$' . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        return curl_exec($curl);
    }


    /**
     * 数字验证
     * return true 正确 return false 错误
     *
     * @param $number
     * @return bool
     */
    public function number($number)
    {
        $regular = '/^[0-9]*$/';
        if (preg_match($regular, $number)) {
            return true;
        }

        return false;
    }


    /**
     * 手机号验证
     * return true 正确 return false 错误
     *
     * @param $phone
     * @return bool
     */
    public function phone($phone)
    {
        $regular = '/^1[3|4|7|5|8|9][0-9]\d{4,8}$/';
        if (preg_match($regular, $phone)) {
            return true;
        }

        return false;
    }


    /**
     * 电子邮箱
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function email($email)
    {
        $regular = '/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(.[a-zA-Z])+$/';
        if (!preg_match($regular, $email)) {
            return true;
        }

        return false;
    }


    /**
     * 钱
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function money($money)
    {
        $regular = '/^([1-9][0-9]*(\.[0-9]{1,2})?)|(0\.[1-9]([0-9])?)|(0\.0[1-9])$/';
        if (preg_match($regular, $money)) {
            return true;
        }

        return false;
    }


    /**
     * 验证时间 12:33
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function time($time)
    {
        $regular = '/^(([0-1][0-9])|([2][0-3]))[\:][0-5][0-9]$/';
        if (preg_match($regular, $time)) {
            return true;
        }

        return false;
    }


    /**
     * 验证时间带秒 12:33:44
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function timeWithSecond($time)
    {
        $regular = '/^(([0-1][0-9])|([2][0-3]))([\:][0-5][0-9]){2}$/';
        if (preg_match($regular, $time)) {
            return true;
        }

        return false;
    }


    /**
     * 验证日期 1911-12-31
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function date($date)
    {
        $bigmonth = '/^(19|20)([0-9][0-9])-(01|03|05|07|08|10|12)-(0[1-9]|1[0-9]|2[0-9]|3[0-1])$/';
        $smallmonth = '/^(19|20)([0-9][0-9])-(04|06|09|11)-(0[1-9]|1[0-9]|2[0-9]|30)$/';
        $february = '/^((19|20)([0-9][0-9])-02-(0[1-9]|1[0-9]|2[0-8]))|((19|20)([02468][048]|[13579][26])-02-29)$/';
        if (preg_match($bigmonth, $date) || preg_match($smallmonth, $date) || preg_match($february, $date)) {
            return true;
        }

        return false;
    }


    /**
     * 时间日期验证 1911-12-31 12:33:44
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function datetime($datetime)
    {
        $length = strlen($datetime);
        $date = substr($datetime, 0, 10);
        $time = substr($datetime, -8);
        $blank = substr($datetime, 10, -8);
        if (($length === 19) && (self::date($date)) && (self::time_with_second($time)) && ($blank === ' ')) {
            return true;
        }

        return false;
    }


    /**
     * 检测星期是否符合标准
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function week($week)
    {
        if ((count($week) > 0) && (count($week) < 8) && ($week === array_unique($week))) {
            foreach ($week as $key => $value) {
                if (!in_array($value, ['1', '2', '3', '4', '5', '6', '7'], true)) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }


    /**
     * 检测日期号是否符合标准
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function day($day)
    {
        if ((count($day) > 0) && (count($day) < 32) && ($day === array_unique($day))) {
            foreach ($day as $key => $value) {
                if (!in_array($value, ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'], true)) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }


    /**
     * 检测日期时间范围
     * true 正确 false 错误
     *
     * @param $start
     * @param $end
     * @return bool
     */
    public function datetimeRange($start, $end)
    {
        if (!self::datetime($start) || !self::datetime($end) || strtotime($start) >= strtotime($end)) {
            return false;
        }

        return true;
    }


    /**
     * 检测时间范围
     * true 正确 false 错误
     *
     * @param $start
     * @param $end
     * @return bool
     */
    public function timeRange($start, $end)
    {
        if ($end === '00:00') {
            $end = '24:00';
            if (!self::time($start) || strtotime($start) >= strtotime($end)) {
                return false;
            }

            return true;
        }

        if (!self::time($start) || !self::time($end) || strtotime($start) >= strtotime($end)) {
            return false;
        }

        return true;
    }


    /**
     * 检测uuid
     * true 正确 false 错误
     *
     * @param
     * @return bool
     */
    public function uuid($uuidStr)
    {
        if (preg_match('/^[0-9a-zA-Z]{8}-[0-9a-zA-Z]{4}-[0-9a-zA-Z]{4}-[0-9a-zA-Z]{4}-[0-9a-zA-Z]{12}$/', $uuidStr)) {
            return true;
        }

        return false;
    }


    /**
     * json格式
     *
     * @param $string
     * @return bool
     */
    public function json($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }


    /**
     * 判断是否合法车牌号
     * 2017年4月7日 14:06:17 增加对 特种车牌，武警车牌,军牌的校验
     * 2018年3月5日 13:32:18 增加对 6位新能源车牌的校验
     *
     * @param $license
     * @return bool
     */
    public function carLicense($license)
    {

        if (empty($license)) {
            return false;
        }
        #匹配民用车牌和使馆车牌
        # 判断标准
        # 1，第一位为汉字省份缩写
        # 2，第二位为大写字母城市编码
        # 3，后面是5位仅含字母和数字的组合
        {
            $regular = '/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新使]{1}[A-Z]{1}[0-9a-zA-Z]{5}$/u';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配特种车牌(挂,警,学,领,港,澳)
        #参考 https://wenku.baidu.com/view/4573909a964bcf84b9d57bc5.html
        {
            $regular = '/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[0-9a-zA-Z]{4}[挂警学领港澳]{1}$/u';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配武警车牌
        #参考 https://wenku.baidu.com/view/7fe0b333aaea998fcc220e48.html
        {
            $regular = '/^WJ[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]?[0-9a-zA-Z]{5}$/ui';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配军牌
        #参考 http://auto.sina.com.cn/service/2013-05-03/18111149551.shtml
        {
            $regular = '/[A-Z]{2}[0-9]{5}$/';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }
        }

        #匹配新能源车辆6位车牌
        #参考 https://baike.baidu.com/item/%E6%96%B0%E8%83%BD%E6%BA%90%E6%B1%BD%E8%BD%A6%E4%B8%93%E7%94%A8%E5%8F%B7%E7%89%8C
        {

            #小型新能源车
            $regular = '/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[DF]{1}[0-9a-zA-Z]{5}$/u';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }

            #大型新能源车
            $regular = '/[京津冀晋蒙辽吉黑沪苏浙皖闽赣鲁豫鄂湘粤桂琼川贵云渝藏陕甘青宁新]{1}[A-Z]{1}[0-9a-zA-Z]{5}[DF]{1}$/u';
            preg_match($regular, $license, $match);
            if (isset($match[0])) {
                return true;
            }

        }

        return false;

    }


}