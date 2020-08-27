<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActressWork */

$this->title = 'Create Adult Video Actress Work';
$this->params['breadcrumbs'][] = ['label' => 'Adult Video Actress Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adult-video-actress-work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
