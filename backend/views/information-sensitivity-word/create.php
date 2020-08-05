<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InformationSensitivityWord */

$this->title = 'Create Information Sensitivity Word';
$this->params['breadcrumbs'][] = ['label' => 'Information Sensitivity Words', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="information-sensitivity-word-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
