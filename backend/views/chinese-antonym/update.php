<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseAntonym */

$this->title = 'Update Chinese Antonym: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Antonyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chinese-antonym-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
