<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActress */

$this->title = '女演员详情';
$this->params['breadcrumbs'][] = ['label' => '女演员列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
            [
                'attribute' => 'avatar',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<img class="avatar-image" src="data:image/png;base64,' . $model->avatar . '" >';
                }
            ],
            'name',
            'raw_name',
            'pinyin',
            'adultVideoActressDetail.describe',
            [
                'attribute' => 'adultVideoActressDetail.information',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->adultVideoActressDetail->information as $key => $value) {
                        $html .= '<span>' . $key . '</span>：';
                        $html .= '<span>' . $value . '</span><br>';
                    }
                    return $html;
                }
            ],
        ],
    ]) ?>

</div>
