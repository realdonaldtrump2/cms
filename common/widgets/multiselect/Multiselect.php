<?php

namespace common\widgets\multiselect;

use yii\base\Widget;


class Multiselect extends Widget
{


    public $id;

    public $name;

    public $data = [];

    public $value = [];

    public $model;

    public $attribute;

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        MultiselectAsset::register($this->getView());
        return $this->render('multiselect', [
            'id' => $this->id,
            'name' => $this->name,
            'data' => $this->data,
            'value' => $this->value
        ]);

    }


}