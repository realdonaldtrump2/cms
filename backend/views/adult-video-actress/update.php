<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActress */

$this->title = 'Update Adult Video Actress: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Adult Video Actresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="adult-video-actress-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
