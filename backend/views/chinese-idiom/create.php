<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseIdiom */

$this->title = 'Create Chinese Idiom';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Idioms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-idiom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
