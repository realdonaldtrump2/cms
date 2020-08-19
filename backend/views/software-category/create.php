<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SoftwareCategory */

$this->title = 'Create Software Category';
$this->params['breadcrumbs'][] = ['label' => 'Software Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="software-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
