<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InformationPositionCategory */

$this->title = 'Update Information Position Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Information Position Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="information-position-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
