<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseNegative */

$this->title = 'Create Chinese Negative';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Negatives', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-negative-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
