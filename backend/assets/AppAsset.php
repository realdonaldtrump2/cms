<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;


class AppAsset extends AssetBundle
{


    public $basePath = '@webroot';


    public $baseUrl = '@web';


    //全局css
    public $css = [
        'vendor/font-awesome/font-awesome.css',
        'vendor/animate/animate.css',
        'vendor/nprogress/nprogress.css',
        'vendor/switchery/dist/switchery.min.css',
        'vendor/starrr/dist/starrr.css',
        'vendor/bootstrap-daterangepicker/daterangepicker.css',
        'vendor/jquery-toast/dist/jquery.toast.css',
        'vendor/magic-input/magic-input.css',
        'vendor/gentelella/gentelella.css',
        'css/common.css',
    ];


    //全局js
    public $js = [
        ['vendor/ie/ie8.js', 'condition' => 'lte IE9', 'position' => \yii\web\View::POS_HEAD],
        'vendor/bootbox/bootbox.js',
        'vendor/metis-menu/metis-menu.js',
        'vendor/nprogress/nprogress.js',
        'vendor/bootstrap-progressbar/bootstrap-progressbar.min.js',
        'vendor/moment/moment.js',
        'vendor/bootstrap-daterangepicker/daterangepicker.js',
        'vendor/switchery/dist/switchery.min.js',
        'vendor/parsleyjs/dist/parsley.min.js',
        'vendor/autosize/dist/autosize.min.js',
        'vendor/devbridge-autocomplete/dist/jquery.autocomplete.min.js',
        'vendor/starrr/dist/starrr.js',
        'vendor/layer/layer.js',
        'vendor/vue/vue.js',
        'vendor/underscore/underscore.js',
        'vendor/mobile-detect.js/mobile-detect.js',
        'vendor/iNotify/dist/notify.js',
        'vendor/jquery.timers/jquery.timers.js',
        'vendor/jquery-toast/dist/jquery.toast.js',
        'vendor/jquery-barcode/jquery-barcode.js',
        'vendor/url/url.js',
        'vendor/php/php.js',
        'vendor/decimal.js/decimal.js',
        'vendor/validator.js/validator.js',
        'vendor/lodop/lodop.js',
        'vendor/gentelella/gentelella.js',
        'js/common.js',
    ];


    public $jsOptions = [
        'position' => View::POS_END,
    ];


    //依赖关系
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


    /**
     * 注册css文件
     *
     * @param $view
     * @param $cssfile
     */
    public static function addCss($view, $cssfile)
    {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => "backend\assets\AppAsset"]);
    }


    /**
     * 注册js文件
     *
     * @param $view
     * @param $jsfile
     */
    public static function addScript($view, $jsfile)
    {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => "backend\assets\AppAsset"]);
    }


}
