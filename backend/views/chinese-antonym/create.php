<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseAntonym */

$this->title = 'Create Chinese Antonym';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Antonyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-antonym-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
