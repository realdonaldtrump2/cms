<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActressWork */

$this->title = '女演员作品详情';
$this->params['breadcrumbs'][] = ['label' => '女演员作品列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
            'title',
            [
                'attribute' => 'cover',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<img class="avatar-image" src="data:image/png;base64,' . $model->cover . '" >';
                }
            ],
            'designation',
            'publish_datetime',
            [
                'attribute' => 'duration',
                'value' => function ($model) {
                    return gmdate('H:i:s', $model->duration);
                }
            ],
            [
                'attribute' => 'information',
                'format' => 'raw',
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->information as $key => $value) {
                        $html .= '<span>' . $key . '</span>：';
                        $html .= '<span>' . $value . '</span><br>';
                    }
                    return $html;
                }
            ],
        ],
    ]) ?>

</div>
