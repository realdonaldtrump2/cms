<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseAntonym */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-antonym-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'front')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'back')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'create_datetime')->textInput() ?>

    <?= $form->field($model, 'update_datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
