<?php

namespace common\widgets\richtext;

use yii\web\AssetBundle;


class RichtextAsset extends AssetBundle
{

    public $js = ['js/summernote.js', 'js/summernote.zh-CN.js'];

    public $css = ['css/summernote.css'];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        parent::init();
    }

}
