<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseCharacterStroke */

$this->title = 'Create Chinese Character Stroke';
$this->params['breadcrumbs'][] = ['label' => 'Chinese Character Strokes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-character-stroke-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
