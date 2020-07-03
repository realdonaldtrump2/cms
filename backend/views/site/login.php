<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = '登录';
$this->context->layout = 'function';

?>

<div class="login_wrapper">
    <div class="animate form login_form">
        <section class="login_content">

            <?php $form = ActiveForm::begin(); ?>

            <div class="form-group">
                <h2><?= Yii::$app->params['applicationName'] ?></h2>
                <br>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'phone')->textInput() ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput() ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'verify_code', [
                    'options' => ['class' => 'form-group'],
                ])->widget(Captcha::className(), [
                    'template' => '<div class="row" ><div class="col-xs-6" >{input}</div><div class="col-xs-6" >{image}</div></div>',
                    'imageOptions' => ['alt' => '验证码'],
                ]); ?>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <?= $form->field($model, 'remember_me')->checkbox() ?>
                    </div>
                    <div class="col-xs-6">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </section>
    </div>
</div>
