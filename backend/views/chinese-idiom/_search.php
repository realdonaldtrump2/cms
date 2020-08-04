<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChineseIdiomSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-idiom-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'word') ?>

    <?= $form->field($model, 'pinyin') ?>

    <?= $form->field($model, 'abbreviation') ?>

    <?= $form->field($model, 'derivation') ?>

    <?php // echo $form->field($model, 'explain') ?>

    <?php // echo $form->field($model, 'example') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'create_datetime') ?>

    <?php // echo $form->field($model, 'update_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
