<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseSynonym */

$this->title = 'Update Chinese Synonym: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Chinese Synonyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chinese-synonym-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
