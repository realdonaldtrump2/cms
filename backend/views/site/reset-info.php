<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '重置密码';
$this->context->layout = 'function';

?>

<div>
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <?php $form = ActiveForm::begin(); ?>
                <h1>重置密码</h1>
                <div class="form-group">
                    <?= $form->field($model, 'phone')->textInput() ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'password')->textInput() ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'sms_code')->textInput() ?>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-6">
                        </div>
                        <div class="col-xs-6">
                            <?= Html::a('登录', ['login'], ['class' => 'pull-right a-pointer']) ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('重置密码', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </section>
        </div>
    </div>
</div>
