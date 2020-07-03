<?php

namespace spider\assets;

use yii\web\AssetBundle;
use yii\web\View;


/**
 * Main spider application asset bundle.
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'css/common.css',
    ];

    public $js = [
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
        $view->registerCssFile($cssfile, [AppAsset::className(), "depends" => "spider\assets\AppAsset"]);
    }

    //注册js文件
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [AppAsset::className(), "depends" => "spider\assets\AppAsset"]);
    }

}
