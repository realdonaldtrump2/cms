<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\InformationPositionCategory */

$this->title = 'Create Information Position Category';
$this->params['breadcrumbs'][] = ['label' => 'Information Position Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="information-position-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
