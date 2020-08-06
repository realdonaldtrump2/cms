<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseIdiom */

$this->title = '汉语成语详情';
$this->params['breadcrumbs'][] = ['label' => '汉语成语列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
            'word',
            'pinyin',
            'abbreviation',
            'derivation',
            'explain',
            'example',
        ],
    ]) ?>

</div>
