<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChineseCharacterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-character-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'word') ?>

    <?= $form->field($model, 'oldword') ?>

    <?= $form->field($model, 'strokes') ?>

    <?= $form->field($model, 'pinyin') ?>

    <?php // echo $form->field($model, 'radicals') ?>

    <?php // echo $form->field($model, 'explain') ?>

    <?php // echo $form->field($model, 'more_explain') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'create_datetime') ?>

    <?php // echo $form->field($model, 'update_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
