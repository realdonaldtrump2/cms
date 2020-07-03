<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '权限添加';
$this->params['breadcrumbs'][] = ['url' => ['permission-index'], 'label' => '权限列表'];
$this->params['breadcrumbs'][] = ['label'=>$this->title];

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'description')->textInput()->label('权限名称') ?>

<?= $form->field($model, 'module')->textInput() ?>

<?= $form->field($model, 'controller')->textInput() ?>

<?= $form->field($model, 'action')->textInput() ?>

<div class="form-group">
    <div class='col-xs-12 col-sm-2'></div>
    <div class='col-xs-12 col-sm-10'>
        <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

