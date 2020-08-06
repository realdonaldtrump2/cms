<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseProverb */

$this->title = '汉语谚语详情';
$this->params['breadcrumbs'][] = ['label' => '汉语谚语列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'word',
            'answer',
        ],
    ]) ?>

</div>
