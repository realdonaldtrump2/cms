<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdultVideoActressWork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adult-video-actress-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adult_video_actress_id')->textInput() ?>

    <?= $form->field($model, 'cover')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'designation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publish_datetime')->textInput() ?>

    <?= $form->field($model, 'duration')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'create_datetime')->textInput() ?>

    <?= $form->field($model, 'update_datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
