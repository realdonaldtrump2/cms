<?php

namespace common\widgets\cropper;

use yii\base\Widget;


class Cropper extends Widget
{

    public $id;

    public $name;

    public $value;

    public $model;

    public $attribute;

    public $width;

    public $height;

    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {

        CropperAsset::register($this->getView());

        return $this->render('cropper', [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'model' => $this->model,
            'attribute' => $this->attribute,
            'width' => $this->width,
            'height' => $this->height,
        ]);

    }

}
