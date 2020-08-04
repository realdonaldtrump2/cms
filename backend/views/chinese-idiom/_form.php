<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChineseIdiom */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="chinese-idiom-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'word')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pinyin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'derivation')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'explain')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'example')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_delete')->textInput() ?>

    <?= $form->field($model, 'create_datetime')->textInput() ?>

    <?= $form->field($model, 'update_datetime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
