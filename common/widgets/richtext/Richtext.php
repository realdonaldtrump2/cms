<?php

namespace common\widgets\richtext;

use yii\base\Widget;


class Richtext extends Widget
{


    public $id;

    public $name;

    public $value;

    public $model;

    public $attribute;

    public $scenario = 'computer';

    public function init()
    {
        parent::init();
    }


    /**
     * @return string
     */
    public function run()
    {
        RichtextAsset::register($this->getView());
        return $this->render('richtext', [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'attribute' => $this->attribute,
            'model' => $this->model,
            'scenario' => $this->scenario,
        ]);
    }


}
