<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$this->context->layout = 'function';

?>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">

            <?php $form = ActiveForm::begin(); ?>

            <h1>注册</h1>
            <div class="form-group">
                <?= $form->field($model, 'phone')->textInput(['placeholder' => '请输入手机号', 'autofocus' => true]) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('注册', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </section>
    </div>
</div>
