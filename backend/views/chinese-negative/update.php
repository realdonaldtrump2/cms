<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseNegative */

$this->title = 'Update Chinese Negative: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Negatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chinese-negative-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
