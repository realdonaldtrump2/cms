<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActress */

$this->title = 'Create Adult Video Actress';
$this->params['breadcrumbs'][] = ['label' => 'Adult Video Actresses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adult-video-actress-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
