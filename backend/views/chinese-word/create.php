<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseWord */

$this->title = 'Create Chinese Word';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
