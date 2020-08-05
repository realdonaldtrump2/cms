<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseSynonym */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-synonym-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'container')->textInput() ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'create_datetime')->textInput() ?>

    <?= $form->field($model, 'update_datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
