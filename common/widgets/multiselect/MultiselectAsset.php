<?php

namespace common\widgets\multiselect;

use yii\web\AssetBundle;

class MultiselectAsset extends AssetBundle
{

    public $js = ['js/jquery.multi-select.js', 'js/jquery.quicksearch.js'];

    public $css = ['css/jquery.multi-select.css'];

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