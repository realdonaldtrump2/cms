<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InformationSensitivityWord */

$this->title = 'Update Information Sensitivity Word: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Information Sensitivity Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="information-sensitivity-word-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
