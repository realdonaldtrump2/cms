<?php

namespace common\widgets\cropper;

use yii\web\AssetBundle;


class CropperAsset extends AssetBundle
{

    public $js = ['js/iscroll-zoom.js', 'js/hammer.js', 'js/lrz.all.bundle.js', 'js/jquery.photoClip.js'];

    public $css = [];

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

