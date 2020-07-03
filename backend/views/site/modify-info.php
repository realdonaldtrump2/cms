<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '修改密码';
$this->context->layout = 'function';

?>

    <?php $form = ActiveForm::begin([
        'id' => 'modify-info',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'new_password')->textInput() ?>

    <?= $form->field($model, 'confirm_password')->textInput() ?>

    <div class="form-group">
        <div class='col-xs-12 col-sm-2'></div>
        <div class='col-xs-12 col-sm-10'>
            <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
