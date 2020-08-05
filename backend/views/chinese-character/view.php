<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTag */

$this->title = '汉语字详情';
$this->params['breadcrumbs'][] = ['label' => '汉语字列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
            'word',
            'oldword',
            'strokes',
            'pinyin',
            'radicals',
            [
                'attribute' => 'explain',
                'format' => 'html',
                'value' => function($model){
                    return '<textarea readonly="readonly" >'.$model->explain.'</textarea>';
                }
            ],
            [
                'attribute' => 'more_explain',
                'format' => 'html',
                'value' => function($model){
                    return '<textarea readonly="readonly" >'.$model->more_explain.'</textarea>';
                }
            ],
        ],
    ]) ?>

</div>
