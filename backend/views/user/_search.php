<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-search well searchForm" hidden>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'create_datetime_start')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
        ]
    ])->label('注册时间开始') ?>

    <?= $form->field($model, 'create_datetime_end')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_INPUT,
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true,
        ]
    ])->label('注册时间结束') ?>

    <div class="form-group">
        <div class='col-xs-12 col-sm-2'></div>
        <div class='col-xs-12 col-sm-10'>
            <?= Html::submitButton('<i class="fa fa-search" ></i> 搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('<i class="fa fa-refresh" ></i> 重置', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-reply" ></i> 清空', ['index'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
