<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseAntonym */

$this->title = '汉语反义词详情';
$this->params['breadcrumbs'][] = ['label' => '汉语反义词列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
            'front_word',
            'back_word',
        ],
    ]) ?>

</div>
