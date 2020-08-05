<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseSynonym */

$this->title = 'Create Chinese Synonym';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Synonyms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-synonym-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
