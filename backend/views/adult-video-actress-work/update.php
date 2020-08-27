<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActressWork */

$this->title = 'Update Adult Video Actress Work: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Adult Video Actress Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="adult-video-actress-work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
