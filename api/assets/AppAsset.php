<?php

namespace api\assets;

use yii\web\AssetBundle;
use yii\web\View;


class AppAsset extends AssetBundle
{


    public $basePath = '@webroot';


    public $baseUrl = '@web';


    public $css = [
    ];


    public $js = [
    ];


    public $jsOptions = [
        'position' => View::POS_END,
    ];


    public $depends = [
    ];


    /**
     * 注册css文件
     *
     * @param $view
     * @param $cssfile
     */
    public static function addCss($view, $cssfile)
    {
        $view->registerCssFile($cssfile, [AppAsset::className(), "depends" => "api\assets\AppAsset"]);
    }


    /**
     * 注册js文件
     *
     * @param $view
     * @param $jsfile
     */
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [AppAsset::className(), "depends" => "api\assets\AppAsset"]);
    }


}
