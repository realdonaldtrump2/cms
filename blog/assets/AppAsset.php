<?php

namespace blog\assets;

use yii\web\AssetBundle;
use yii\web\View;


/**
 * Main blog application asset bundle.
 */
class AppAsset extends AssetBundle
{


    public $basePath = '@webroot';


    public $baseUrl = '@web';


    public $css = [
        'vendor/bootstrap/bootstrap.css',
        'vendor/ionicons/ionicons.css',
        'vendor/pace/pace.css',
        'css/common.css',
    ];


    public $js = [
        ['vendor/ie/ie8.js', 'condition' => 'lte IE9', 'position' => \yii\web\View::POS_HEAD],
        'vendor/jquery/jquery.js',
        'vendor/bootstrap/bootstrap.js',
        'vendor/pace/pace.js',
        'vendor/modernizr/modernizr.js',
        'js/common.js',
    ];


    public $jsOptions = [
        'position' => View::POS_END,
    ];


    public $depends = [
    ];


    //注册css文件
    public static function addCss($view, $cssfile)
    {
        $view->registerCssFile($cssfile, [AppAsset::className(), "depends" => "blog\assets\AppAsset"]);
    }


    //注册js文件
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [AppAsset::className(), "depends" => "blog\assets\AppAsset"]);
    }

}
