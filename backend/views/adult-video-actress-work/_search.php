<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AdultVideoActressWorkSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adult-video-actress-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'adult_video_actress_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'cover') ?>

    <?= $form->field($model, 'cover_url') ?>

    <?php // echo $form->field($model, 'designation') ?>

    <?php // echo $form->field($model, 'information') ?>

    <?php // echo $form->field($model, 'publish_datetime') ?>

    <?php // echo $form->field($model, 'duration') ?>

    <?php // echo $form->field($model, 'is_delete') ?>

    <?php // echo $form->field($model, 'create_datetime') ?>

    <?php // echo $form->field($model, 'update_datetime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
