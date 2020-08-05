<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ChineseAntonymSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-antonym-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'front') ?>

    <?= $form->field($model, 'back') ?>

    <?= $form->field($model, 'is_delete') ?>

    <?= $form->field($model, 'create_datetime') ?>

    <?php // echo $form->field($model, 'update_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
