<?php

namespace common\components;


use Yii;
use yii\base\Component;


class FormatField extends Component
{


    /**
     * 隐藏
     *
     * @param $string
     * @param $num
     * @param $numb
     * @return mixed
     */
    public function invisible($string, $num, $numb)
    {
        $length = mb_strlen($string, 'utf8') - $num - $numb;
        $str = str_repeat("*", $length);//替换字符数量
        return substr_replace($string, $str, $num, $length);
    }


    /**
     * 金额分转换为字符串元
     *
     * @param $value
     * @return string
     */
    public function money($value)
    {
        return number_format($value / 100.00, 2, '.', '');
    }


    /**
     * 转大写
     *
     * @param $str
     * @return string
     */
    public function strToUpper($str)
    {
        return strtoupper($str);
    }


    /**
     * 转小写
     *
     * @param $str
     * @return string
     */
    public function strToLower($str)
    {
        return strtolower($str);
    }


    /**
     * 大驼峰转下划线
     *
     * @param $str
     * @return string|string[]|null
     */
    public function bigUpperToUnderLine($str)
    {

        $str = lcfirst($str);
        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;

    }


    /**
     * 大驼峰转中划线
     *
     * @param $str
     * @return string|string[]|null
     */
    public function bigUpperToMiddleLine($str)
    {

        $str = lcfirst($str);
        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '-' . strtolower($matches[0]);
        }, $str);
        return $str;

    }


    /**
     * 小驼峰转下划线
     *
     * @param $str
     * @return string|string[]|null
     */
    public function smallUpperToUnderLine($str)
    {

        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;

    }


    /**
     * 小驼峰转中划线
     *
     * @param $str
     * @return string|string[]|null
     */
    public function smallUpperToMiddleLine($str)
    {

        $str = preg_replace_callback('/([A-Z])/', function ($matches) {
            return '-' . strtolower($matches[0]);
        }, $str);
        return $str;

    }


    /**
     * 下划线转小驼峰
     *
     * @param $str
     * @return string|string[]|null
     */
    public function underLineToSmallUpper($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return $str;
    }


}

